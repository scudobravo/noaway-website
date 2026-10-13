<?php
/**
 * NoAway API - Validazione licenza + scrittura statistiche
 * POST JSON: { license_key, device_id [, app_version, platform, activity_mode, detected_apps, active_seconds_today ] }
 * Verifica licenza/dispositivo e aggiorna le statistiche in noaway_licenses (stesso MySQL di WordPress).
 * Solo POST, body JSON, max 2KB.
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'invalid', 'message' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
if (strlen($raw) > 2048) {
    http_response_code(400);
    echo json_encode(['status' => 'invalid', 'message' => 'Payload too large']);
    exit;
}
$body = json_decode($raw, true);
if (!is_array($body)) {
    http_response_code(400);
    echo json_encode(['status' => 'invalid', 'message' => 'Invalid JSON']);
    exit;
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/licenseKey.php';
require_once __DIR__ . '/rateLimit.php';

if (!noaway_rate_limit_check('validate')) {
    http_response_code(429);
    echo json_encode(['status' => 'invalid', 'message' => 'Too many requests']);
    exit;
}

$license_key = isset($body['license_key']) ? normalizeKey($body['license_key']) : '';
$device_id   = isset($body['device_id']) ? trim($body['device_id']) : '';

if (!isValidFormat($license_key)) {
    echo json_encode(['status' => 'invalid']);
    exit;
}
if (strlen($device_id) < 16 || strlen($device_id) > 128) {
    echo json_encode(['status' => 'invalid']);
    exit;
}

try {
    $pdo = noaway_get_pdo();

    $stmt = $pdo->prepare('SELECT id, max_devices FROM noaway_licenses WHERE license_key = ?');
    $stmt->execute([$license_key]);
    $license = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$license) {
        echo json_encode(['status' => 'invalid']);
        exit;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM noaway_activations WHERE license_key = ? AND device_id = ?');
    $stmt->execute([$license_key, $device_id]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare('SELECT COUNT(*) AS cnt FROM noaway_activations WHERE license_key = ?');
        $stmt->execute([$license_key]);
        $count = (int) $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
        $max   = (int) $license['max_devices'];
        if ($count >= $max) {
            echo json_encode(['status' => 'invalid']);
            exit;
        }
    }

    // Statistiche (opzionali): sanitize e aggiorna noaway_licenses — allineato all’app desktop.
    $app_version   = isset($body['app_version']) ? substr(trim((string) $body['app_version']), 0, 20) : null;
    $platform      = isset($body['platform']) ? strtolower(trim((string) $body['platform'])) : null;
    $activity_mode = isset($body['activity_mode']) ? strtolower(trim((string) $body['activity_mode'])) : null;
    $detected_apps = null;
    if (isset($body['detected_apps']) && is_array($body['detected_apps'])) {
        $allowed = ['teams', 'slack', 'zoom', 'discord'];
        $out     = [];
        foreach (array_slice($body['detected_apps'], 0, 10) as $a) {
            $a = strtolower(trim((string) $a));
            if (in_array($a, $allowed, true)) {
                $out[] = $a;
            }
        }
        $detected_apps = $out === [] ? null : json_encode($out);
    }
    $active_seconds_today = null;
    if (isset($body['active_seconds_today'])) {
        $n = (int) $body['active_seconds_today'];
        if ($n >= 0 && $n <= 86400) {
            $active_seconds_today = $n;
        }
    }

    $now = date('Y-m-d H:i:s');

    if ($app_version !== null && $platform !== null && $activity_mode !== null) {
        $stmt = $pdo->prepare('
            UPDATE noaway_licenses
            SET last_validation = ?, last_device = ?, last_version = ?, last_platform = ?, last_activity_mode = ?, last_detected_apps = ?
            WHERE license_key = ?
        ');
        $stmt->execute([
            $now,
            $device_id,
            $app_version,
            $platform,
            $activity_mode,
            $detected_apps,
            $license_key,
        ]);
    } else {
        $stmt = $pdo->prepare('UPDATE noaway_licenses SET last_validation = ?, last_device = ? WHERE license_key = ?');
        $stmt->execute([$now, $device_id, $license_key]);
    }

    if ($active_seconds_today !== null) {
        $stmt = $pdo->prepare('
            UPDATE noaway_licenses
            SET last_active_seconds = ?, total_active_seconds = COALESCE(total_active_seconds, 0) + ?
            WHERE license_key = ?
        ');
        $stmt->execute([$active_seconds_today, $active_seconds_today, $license_key]);
    }

    echo json_encode(['status' => 'valid']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'invalid', 'message' => 'Server error']);
}

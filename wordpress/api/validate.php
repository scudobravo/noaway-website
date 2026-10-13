<?php
/**
 * NoAway API - License validation (no activity/usage telemetry).
 * POST JSON: { license_key, device_id }
 * Optional ignored fields from older clients are not stored.
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

    $now = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare('UPDATE noaway_licenses SET last_validation = ?, last_device = ? WHERE license_key = ?');
    $stmt->execute([$now, $device_id, $license_key]);

    echo json_encode(['status' => 'valid']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'invalid', 'message' => 'Server error']);
}

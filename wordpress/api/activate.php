<?php
/**
 * NoAway API - Attivazione dispositivo
 * POST JSON: { license_key, email, device_id }
 * Scrive su noaway_activations (stesso MySQL di WordPress).
 * Solo POST, body JSON, max 1KB.
 */

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
if (strlen($raw) > 1024) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Payload too large']);
    exit;
}
$body = json_decode($raw, true);
if (!is_array($body)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
    exit;
}

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/licenseKey.php';
require_once __DIR__ . '/rateLimit.php';

if (!noaway_rate_limit_check('activate')) {
    http_response_code(429);
    echo json_encode(['status' => 'error', 'message' => 'Too many attempts']);
    exit;
}

$license_key = isset($body['license_key']) ? normalizeKey($body['license_key']) : '';
$email       = isset($body['email']) ? trim($body['email']) : '';
$device_id   = isset($body['device_id']) ? trim($body['device_id']) : '';

if (!isValidFormat($license_key)) {
    http_response_code(400);
    echo json_encode(['status' => 'invalid_license', 'message' => 'Invalid license key']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'invalid_email', 'message' => 'Invalid email']);
    exit;
}
$email = strtolower($email);
if (strlen($device_id) < 16 || strlen($device_id) > 128) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid device_id']);
    exit;
}

try {
    $pdo = noaway_get_pdo();
    global $noaway_max_devices;

    $stmt = $pdo->prepare('SELECT id, max_devices FROM noaway_licenses WHERE license_key = ? AND LOWER(email) = ?');
    $stmt->execute([$license_key, $email]);
    $license = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$license) {
        http_response_code(404);
        echo json_encode(['status' => 'invalid_license', 'message' => 'License not found or email does not match']);
        exit;
    }

    $stmt = $pdo->prepare('SELECT 1 FROM noaway_activations WHERE license_key = ? AND device_id = ?');
    $stmt->execute([$license_key, $device_id]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'valid']);
        exit;
    }

    $stmt = $pdo->prepare('SELECT COUNT(*) AS cnt FROM noaway_activations WHERE license_key = ?');
    $stmt->execute([$license_key]);
    $count = (int) $stmt->fetch(PDO::FETCH_ASSOC)['cnt'];
    $max   = (int) ($license['max_devices'] ?? $noaway_max_devices);

    if ($count >= $max) {
        http_response_code(403);
        echo json_encode(['status' => 'limit_reached', 'message' => 'Maximum devices reached for this license']);
        exit;
    }

    $pdo->prepare('INSERT INTO noaway_activations (license_key, device_id) VALUES (?, ?)')->execute([$license_key, $device_id]);
    echo json_encode(['status' => 'valid']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Server error']);
}

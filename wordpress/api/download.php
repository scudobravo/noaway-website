<?php
/**
 * NoAway API - Download protetto installer (mac/win)
 * GET ?t=TOKEN&p=mac|win&e=EXPIRY
 * Token = HMAC-SHA256(license_key|email|platform|expiry, NOAWAY_DOWNLOAD_SECRET) in hex.
 * Config: NOAWAY_DOWNLOAD_SECRET, NOAWAY_RELEASES_PATH, NOAWAY_RELEASE_MACOS, NOAWAY_RELEASE_WINDOWS in wp-config.
 */

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit('Method not allowed');
}

$token = isset($_GET['t']) ? trim($_GET['t']) : '';
$platform = isset($_GET['p']) ? strtolower(trim($_GET['p'])) : '';
$expiry = isset($_GET['e']) ? (int) $_GET['e'] : 0;

if ($token === '' || $platform === '' || $expiry <= 0) {
    http_response_code(400);
    exit('Invalid parameters');
}

if ($platform !== 'mac' && $platform !== 'win') {
    http_response_code(400);
    exit('Invalid platform');
}

// Carica wp-config per le costanti (NOAWAY_DOWNLOAD_SECRET, NOAWAY_RELEASES_PATH, ecc.)
$wp_config_paths = [
    __DIR__ . '/../wp-config.php',
    __DIR__ . '/../../wp-config.php',
];
$wp_loaded = false;
foreach ($wp_config_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $wp_loaded = true;
        break;
    }
}

if (!$wp_loaded || !defined('NOAWAY_DOWNLOAD_SECRET') || NOAWAY_DOWNLOAD_SECRET === '') {
    http_response_code(503);
    exit('Download not configured');
}

if (time() > $expiry) {
    http_response_code(403);
    exit('Download link expired');
}

// Il token è generato dal License Server: HMAC-SHA256(platform + "|" + expiry + "|" + id, secret)
// con id = hash(license_key|email) per legare il link alla licenza senza esporre dati in URL.
$id = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($id === '' || strlen($id) > 128 || !preg_match('/^[a-f0-9]+$/', $id)) {
    http_response_code(400);
    exit('Invalid link');
}

$payload = $platform . '|' . $expiry . '|' . $id;
$expected = hash_hmac('sha256', $payload, NOAWAY_DOWNLOAD_SECRET);
if (!hash_equals($expected, $token)) {
    http_response_code(403);
    exit('Invalid token');
}

$basePath = defined('NOAWAY_RELEASES_PATH') ? rtrim(NOAWAY_RELEASES_PATH, '/') : '';
$fileName = $platform === 'mac'
    ? (defined('NOAWAY_RELEASE_MACOS') ? NOAWAY_RELEASE_MACOS : 'NoAway.dmg')
    : (defined('NOAWAY_RELEASE_WINDOWS') ? NOAWAY_RELEASE_WINDOWS : 'NoAway-Setup.exe');

if ($basePath === '') {
    http_response_code(503);
    exit('Releases path not configured');
}

$filePath = $basePath . '/' . $fileName;
if (!is_file($filePath) || !is_readable($filePath)) {
    http_response_code(404);
    exit('File not found');
}

$mime = $platform === 'mac' ? 'application/octet-stream' : 'application/octet-stream';
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: no-store');
readfile($filePath);
exit;

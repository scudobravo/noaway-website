<?php
/**
 * Protected download endpoint (HMAC must match license-server email.js).
 * URL: https://noaway.app/api/download.php?t=...&p=...&e=...&id=...
 *
 * Platforms:
 *   mac            → legacy, same file as universal
 *   mac_universal  → NOAWAY_RELEASE_MACOS (universal .dmg)
 *   mac_arm64      → NOAWAY_RELEASE_MACOS_ARM64 (or fallback to universal)
 *   win            → NOAWAY_RELEASE_WINDOWS
 *
 * Requires in wp-config.php: NOAWAY_DOWNLOAD_SECRET, NOAWAY_RELEASES_PATH,
 * NOAWAY_RELEASE_MACOS, NOAWAY_RELEASE_WINDOWS, and NOAWAY_RELEASE_MACOS_ARM64 for arm64 builds.
 */

declare(strict_types=1);

if (! defined('ABSPATH')) {
	// Load WordPress (parent of /api/ = site root)
	$wp_load = dirname(__DIR__) . '/wp-load.php';
	if (is_readable($wp_load)) {
		require_once $wp_load;
	} else {
		http_response_code(500);
		header('Content-Type: text/plain; charset=utf-8');
		echo 'Server misconfiguration: wp-load.php not found.';
		exit;
	}
}

if (! defined('NOAWAY_DOWNLOAD_SECRET') || ! NOAWAY_DOWNLOAD_SECRET) {
	http_response_code(503);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Downloads are not configured.';
	exit;
}

if (! defined('NOAWAY_RELEASES_PATH') || ! NOAWAY_RELEASES_PATH) {
	http_response_code(503);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Release path not configured.';
	exit;
}

$token = isset($_GET['t']) ? (string) $_GET['t'] : '';
$platform = isset($_GET['p']) ? (string) $_GET['p'] : '';
$expiry = isset($_GET['e']) ? (string) $_GET['e'] : '';
$id = isset($_GET['id']) ? (string) $_GET['id'] : '';

$allowed = array( 'mac', 'mac_universal', 'mac_arm64', 'win' );
if ($token === '' || $expiry === '' || $id === '' || ! in_array($platform, $allowed, true)) {
	http_response_code(400);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Invalid request.';
	exit;
}

$exp = (int) $expiry;
if ($exp < time()) {
	http_response_code(403);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'This download link has expired.';
	exit;
}

$payload = $platform . '|' . $expiry . '|' . $id;
$expected = hash_hmac('sha256', $payload, NOAWAY_DOWNLOAD_SECRET);

if (! hash_equals($expected, $token)) {
	http_response_code(403);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Invalid or tampered link.';
	exit;
}

/**
 * Resolve installer filename for signed platform key.
 */
function noaway_release_filename(string $platform): string {
	switch ($platform) {
		case 'mac':
		case 'mac_universal':
			if (defined('NOAWAY_RELEASE_MACOS_UNIVERSAL') && NOAWAY_RELEASE_MACOS_UNIVERSAL) {
				return (string) NOAWAY_RELEASE_MACOS_UNIVERSAL;
			}
			if (defined('NOAWAY_RELEASE_MACOS') && NOAWAY_RELEASE_MACOS) {
				return (string) NOAWAY_RELEASE_MACOS;
			}
			return '';
		case 'mac_arm64':
			if (defined('NOAWAY_RELEASE_MACOS_ARM64') && NOAWAY_RELEASE_MACOS_ARM64) {
				return (string) NOAWAY_RELEASE_MACOS_ARM64;
			}
			// Single-build deploy: serve universal if arm64 not set
			if (defined('NOAWAY_RELEASE_MACOS') && NOAWAY_RELEASE_MACOS) {
				return (string) NOAWAY_RELEASE_MACOS;
			}
			return '';
		case 'win':
			return (defined('NOAWAY_RELEASE_WINDOWS') && NOAWAY_RELEASE_WINDOWS)
				? (string) NOAWAY_RELEASE_WINDOWS
				: '';
		default:
			return '';
	}
}

$filename = noaway_release_filename($platform);
if ($filename === '') {
	http_response_code(503);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'Installer not configured for this platform.';
	exit;
}

$base = rtrim((string) NOAWAY_RELEASES_PATH, '/\\');
$path = $base . DIRECTORY_SEPARATOR . $filename;

if (! is_readable($path) || ! is_file($path)) {
	http_response_code(404);
	header('Content-Type: text/plain; charset=utf-8');
	echo 'File not found.';
	exit;
}

$size = filesize($path);
$mime = 'application/octet-stream';
$low = strtolower($filename);
if (substr($low, -4) === '.dmg') {
	$mime = 'application/x-apple-diskimage';
} elseif (substr($low, -4) === '.exe') {
	$mime = 'application/vnd.microsoft.portable-executable';
}

header('Content-Type: ' . $mime);
header('Content-Length: ' . (string) $size);
header('Content-Disposition: attachment; filename="' . str_replace('"', '', $filename) . '"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');

$fh = fopen($path, 'rb');
if ($fh === false) {
	http_response_code(500);
	exit;
}
while (! feof($fh)) {
	echo fread($fh, 65536);
}
fclose($fh);
exit;

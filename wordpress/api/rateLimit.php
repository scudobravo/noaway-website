<?php
/**
 * NoAway API - Rate limiting per IP + endpoint (MySQL).
 * Limiti: activate 20/15min, validate 60/15min.
 */

if (!function_exists('noaway_get_pdo')) {
    require_once __DIR__ . '/db.php';
}

const NOAWAY_RATE_WINDOW_MINUTES = 15;
const NOAWAY_RATE_ACTIVATE_MAX = 20;
const NOAWAY_RATE_VALIDATE_MAX = 60;

/**
 * IP client (proxy-safe).
 * @return string
 */
function noaway_client_ip() {
    $keys = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
    foreach ($keys as $k) {
        if (!empty($_SERVER[$k])) {
            $ip = trim(explode(',', $_SERVER[$k])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

/**
 * Verifica rate limit e incrementa. true = consentito, false = superato.
 * @param string $endpoint 'activate' o 'validate'
 * @return bool
 */
function noaway_rate_limit_check($endpoint) {
    $pdo = noaway_get_pdo();
    $ip = noaway_client_ip();
    $max = $endpoint === 'activate' ? NOAWAY_RATE_ACTIVATE_MAX : NOAWAY_RATE_VALIDATE_MAX;
    $windowStart = date('Y-m-d H:i:s', strtotime('-' . NOAWAY_RATE_WINDOW_MINUTES . ' minutes'));

    $pdo->exec("CREATE TABLE IF NOT EXISTS noaway_rate_limit (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ip_address VARCHAR(45) NOT NULL,
        endpoint VARCHAR(64) NOT NULL,
        request_count INT NOT NULL DEFAULT 1,
        window_start DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_ip_endpoint (ip_address, endpoint),
        INDEX idx_window (window_start)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $del = $pdo->prepare('DELETE FROM noaway_rate_limit WHERE ip_address = ? AND endpoint = ? AND window_start < ?');
    $del->execute([$ip, $endpoint, $windowStart]);

    $stmt = $pdo->prepare('SELECT request_count, window_start FROM noaway_rate_limit WHERE ip_address = ? AND endpoint = ? ORDER BY window_start DESC LIMIT 1');
    $stmt->execute([$ip, $endpoint]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $pdo->prepare('INSERT INTO noaway_rate_limit (ip_address, endpoint, request_count) VALUES (?, ?, 1)')->execute([$ip, $endpoint]);
        return true;
    }

    $count = (int) $row['request_count'];
    $ws = $row['window_start'];
    if (strtotime($ws) < strtotime($windowStart)) {
        $pdo->prepare('INSERT INTO noaway_rate_limit (ip_address, endpoint, request_count) VALUES (?, ?, 1)')->execute([$ip, $endpoint]);
        return true;
    }

    if ($count >= $max) {
        return false;
    }

    $pdo->prepare('UPDATE noaway_rate_limit SET request_count = request_count + 1 WHERE ip_address = ? AND endpoint = ? AND window_start = ?')
        ->execute([$ip, $endpoint, $ws]);
    return true;
}

<?php
/**
 * NoAway API - Connessione DB (PDO + MySQL)
 * Credenziali da config (WordPress wp-config.php).
 */

if (!defined('NOAWAY_LOADED')) {
    require_once __DIR__ . '/config.php';
}

$noaway_pdo = null;

/**
 * @return PDO
 * @throws PDOException
 */
function noaway_get_pdo() {
    global $noaway_pdo, $noaway_db;
    if ($noaway_pdo !== null) {
        return $noaway_pdo;
    }
    $c = $noaway_db;
    $dsn = 'mysql:host=' . $c['host'] . ';dbname=' . $c['dbname'] . ';charset=utf8mb4';
    $noaway_pdo = new PDO($dsn, $c['user'], $c['password'], [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $noaway_pdo;
}

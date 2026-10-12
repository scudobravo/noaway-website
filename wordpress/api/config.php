<?php
/**
 * NoAway API - Configurazione
 * Usa il database MySQL di WordPress (noaway.app). Nessun Composer, solo PHP.
 */

define('NOAWAY_LOADED', true);

// Carica credenziali da WordPress (wp-config.php nella root del sito)
$wp_config_paths = [
    __DIR__ . '/../wp-config.php',
    __DIR__ . '/../../wp-config.php',
];
foreach ($wp_config_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        if (defined('DB_NAME') && defined('DB_USER') && defined('DB_PASSWORD') && defined('DB_HOST')) {
            $GLOBALS['noaway_db'] = [
                'host'     => DB_HOST,
                'dbname'   => DB_NAME,
                'user'     => DB_USER,
                'password' => DB_PASSWORD,
            ];
            break;
        }
    }
}

// Se non sei in WordPress, imposta variabili d'ambiente o modifica qui
if (empty($GLOBALS['noaway_db'])) {
    $GLOBALS['noaway_db'] = [
        'host'     => getenv('NOAWAY_DB_HOST') ?: 'localhost',
        'dbname'   => getenv('NOAWAY_DB_NAME') ?: '',
        'user'     => getenv('NOAWAY_DB_USER') ?: '',
        'password' => getenv('NOAWAY_DB_PASSWORD') ?: '',
    ];
}

// Limite dispositivi per licenza
$GLOBALS['noaway_max_devices'] = (int) (getenv('MAX_DEVICES_PER_LICENSE') ?: 2);

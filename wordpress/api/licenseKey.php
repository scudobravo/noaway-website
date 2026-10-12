<?php
/**
 * NoAway API - Utility chiave licenza
 * Formato: NOAWAY-XXXX-XXXX-XXXX
 * Alfabeto: ABCDEFGHJKLMNPQRSTUVWXYZ23456789 (no 0/O, 1/I)
 */

const NOAWAY_KEY_CHARS = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
const NOAWAY_KEY_SEGMENT_LENGTH = 4;
const NOAWAY_KEY_SEGMENTS = 4;
const NOAWAY_KEY_PREFIX = 'NOAWAY';

/**
 * Genera una nuova chiave licenza.
 * @return string
 */
function generateLicenseKey() {
    $parts = [NOAWAY_KEY_PREFIX];
    $len = strlen(NOAWAY_KEY_CHARS);
    for ($s = 0; $s < NOAWAY_KEY_SEGMENTS; $s++) {
        $seg = '';
        for ($i = 0; $i < NOAWAY_KEY_SEGMENT_LENGTH; $i++) {
            $seg .= NOAWAY_KEY_CHARS[random_int(0, $len - 1)];
        }
        $parts[] = $seg;
    }
    return implode('-', $parts);
}

/**
 * Normalizza chiave: trim, maiuscolo, niente spazi.
 * @param string $input
 * @return string
 */
function normalizeKey($input) {
    if (!is_string($input)) {
        return '';
    }
    return strtoupper(trim(preg_replace('/\s+/', '', $input)));
}

/**
 * Verifica formato chiave (NOAWAY-XXXX-XXXX-XXXX).
 * @param string $key chiave normalizzata
 * @return bool
 */
function isValidFormat($key) {
    $n = normalizeKey($key);
    return (bool) preg_match('/^NOAWAY-[A-Z2-9]{4}-[A-Z2-9]{4}-[A-Z2-9]{4}$/', $n);
}

# WordPress (noaway.app)

Contiene il tema **noaway-theme** e blocchi HTML riutilizzabili per le pagine pubbliche.

## Tema `noaway-theme`

Percorso: `wp-content/themes/noaway-theme/`

1. Carica la cartella sul server (deploy via `.cpanel.yml`).
2. In **Aspetto → Temi**, attiva **NoAway**.
3. La pagina **Download** usa il template **Downloads NoAway** (`page-downloads.php`).
4. I pulsanti piattaforma (Apple Silicon / Intel / Windows) vanno al **checkout**. Gli installer arrivano solo dopo l’acquisto (thank-you + email firmata via `api/download.php`).

### Download protetti

Non esporre URL pubblici a `.dmg` / `.exe`. Configura `NOAWAY_RELEASES_PATH` e i filename in `wp-config.php` (vedi `wp-config.noaway-example.php`). Preferisci una cartella fuori dalla web root; se i file restano sotto `uploads/noaway-releases/`, assicurati che ci sia il `.htaccess` Deny-all (copiato dal deploy).

### Email post-acquisto (license-server)

Il license-server invia link firmati a `api/download.php` (`mac_universal`, `mac_arm64`, `win`). La pagina thank-you verifica la sessione Stripe e mostra gli stessi link una sola volta.

## Blocco Gutenberg

File: `blocks/download-macos-section-en.html` — se lo usi, sostituisci i placeholder con l’URL di checkout (non con URL diretti ai file).

## Deploy

Vedi `.cpanel.yml` e le regole deploy nel progetto.

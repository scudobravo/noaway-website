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

Il license-server invia link firmati a `api/download.php` (`mac_arm64` / `mac_universal`, `win`) tramite `DOWNLOAD_SECRET`. La thank-you (`?session_id={CHECKOUT_SESSION_ID}`) chiama `GET /post-purchase-downloads` e mostra gli stessi link una sola volta.

Env license-server rilevanti: `DOWNLOAD_SECRET`, `DOWNLOAD_BASE_URL=https://noaway.app/api/download.php`, `DOWNLOAD_LINK_EXPIRY_DAYS`, `STRIPE_SUCCESS_URL=https://noaway.app/thank-you?session_id={CHECKOUT_SESSION_ID}`.

Supporto (mint link): `node scripts/mint-download-links.js <email> <licenseKey>` nella cartella license-server.

### Fattura elettronica — form `/invoice-details/`

Dopo l’acquisto, l’email di licenza include un link firmato a `https://noaway.app/invoice-details/?d=…&key=…` (token AES-GCM da `BILLING_FORM_SECRET`). La pagina WordPress (template **Invoice details**) raccoglie solo dati di privati (indirizzo, CAP, comune, provincia, paese, codice fiscale se IT) e li invia a `support@noaway.app`.

Configura lo **stesso** secret in:
- license-server `.env` → `BILLING_FORM_SECRET`
- `wp-config.php` → `NOAWAY_BILLING_FORM_SECRET`

## Blocco Gutenberg

File: `blocks/download-macos-section-en.html` — se lo usi, sostituisci i placeholder con l’URL di checkout (non con URL diretti ai file).

## Deploy

### Sito WordPress (cPanel / `noaway.app`)

Push su `main` del repo **noaway-website**: cPanel Git Deployment esegue `.cpanel.yml` e copia su `/home/izmljlig/public_html`:

- tema `noaway-theme`
- plugin `noaway-analytics`
- `api/download.php` → `$DEPLOYPATH/api/download.php`
- `robots.txt`, `llms.txt`

Dopo il deploy tema: in wp-admin ri-salva **Impostazioni → Permalink**.  
Assicurati che in `wp-config.php` esistano `NOAWAY_DOWNLOAD_SECRET` e `NOAWAY_BILLING_FORM_SECRET` (allineati al license-server).

### License API (`license.noaway.app`)

Non passa da `.cpanel.yml`. Vedi `../license-server/DEPLOY.md` (repo monorepo `noaway`) oppure la copia in `Websites/NoAway/license-server/DEPLOY.md`.

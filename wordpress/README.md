# WordPress (noaway.app)

Contiene il tema **noaway-theme** e blocchi HTML riutilizzabili per le pagine pubbliche (download Mac, ecc.).

## Tema `noaway-theme`

Percorso: `wp-content/themes/noaway-theme/`

1. Carica la cartella sul server (es. `rsync` verso `wp-content/themes/noaway-theme/`).
2. In **Aspetto → Temi**, attiva **NoAway**.
3. Crea o modifica la pagina **Download** (slug consigliato: `download`).
4. Nel pannello di destra, sotto **Pagina** → **Modello**, scegli:
   - **Download (macOS — universal & Apple Silicon)** — testo **inglese**
   - oppure **Download Mac (IT) — universal e Apple Silicon** — testo **italiano**

### URL dei file `.dmg`

Di default i pulsanti puntano a `https://noaway.app/download/` (placeholder).  
Imposta gli URL reali nel `wp-config.php` **prima** della riga `require` finale:

```php
define('NOAWAY_MAC_UNIVERSAL_DMG', 'https://noaway.app/percorso/NoAway-1.0.x.dmg');
define('NOAWAY_MAC_ARM64_DMG', 'https://noaway.app/percorso/NoAway-1.0.x-arm64.dmg');
```

Oppure sostituisci gli `href` nei template PHP se preferisci valori fissi.

### Email post-acquisto (license-server)

Oggi l’email può contenere un solo link `p=mac` verso l’API download. Per offrire **due** DMG distinti (universal vs arm64) agli acquirenti, vanno aggiornati **license-server** (`email.js`) e la logica `/api/download` per accettare due piattaforme (es. `mac` e `mac-arm64`) e due file su disco. La pagina WordPress è indipendente e può già mostrare due pulsanti con URL pubblici o firmati.

## Blocco Gutenberg

File: `blocks/download-macos-section-en.html` — incolla in un blocco **HTML personalizzato** e sostituisci `DOWNLOAD_URL_ARM64` / `DOWNLOAD_URL_UNIVERSAL`.

## Deploy (richiamo)

Vedi anche `DEPLOY-PRODUCTION.md` nella root del repository.

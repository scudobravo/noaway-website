# Ottimizzazioni performance (Lighthouse)

Questo tema applica già diverse ottimizzazioni. Per migliorare ulteriormente lo score:

## Cache degli asset (Lighthouse: "Use efficient cache lifetimes")

Lighthouse segnala risorse con **Cache TTL: None** (es. `style.css`, `logo.svg`, immagini, `wp-emoji-release.min.js`). Il tema ha disabilitato gli emoji; per il resto la cache va configurata **lato server**.

### Apache (.htaccess)

Se il sito è su Apache, aggiungi nella **root del sito** (dove si trova `wp-config.php` o la cartella `wp-content`) un blocco come questo, **senza sovrascrivere** le regole WordPress esistenti (in particolare `RewriteRule .* - [L]`):

```apache
# Cache statica per tema e upload (1 anno per versioned assets, 1 settimana per immagini)
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/png "access plus 1 month"
  ExpiresByType image/jpeg "access plus 1 month"
  ExpiresByType image/webp "access plus 1 month"
  ExpiresByType image/svg+xml "access plus 1 month"
  ExpiresByType text/css "access plus 1 year"
  ExpiresByType application/javascript "access plus 1 year"
  ExpiresByType font/woff2 "access plus 1 year"
</IfModule>

<IfModule mod_headers.c>
  <FilesMatch "\.(css|js|woff2?|png|jpe?g|webp|svg|ico)$">
    Header set Cache-Control "public, max-age=31536000"
  </FilesMatch>
</IfModule>
```

Se il tuo host (es. Netsons) gestisce la cache da pannello, usa lì le stesse durate per CSS, JS e immagini.

### Nginx

In `server` o `location` per i file statici:

```nginx
location ~* \.(css|js|woff2?|png|jpe?g|webp|svg|ico)$ {
  expires 1y;
  add_header Cache-Control "public, max-age=31536000";
}
```

## Cosa fa già il tema

- **Preconnect** per `fonts.googleapis.com`, `fonts.gstatic.com`, `consentcdn.cookiebot.com`
- **Preload** dell’immagine hero (LCP) sulla sola front page
- **Cookiebot** caricato con `async`
- **Google Fonts** e Material Symbols caricati in modo **non bloccante** (media="print" + onload)
- **Tailwind**: se esiste `assets/css/tailwind.css` viene usato quel CSS (build con `npm run build`). Niente script da 127 KiB, meno main-thread work su mobile. Se il file non c’è, fallback al CDN.
- **Emoji WordPress** disabilitati (meno una richiesta e ~5 KiB)

## Build Tailwind (per produzione / mobile)

Per usare il CSS compilato invece del CDN (consigliato per Lighthouse mobile):

```bash
cd wp-content/themes/noaway-theme
npm install
npm run build
```

Viene generato `assets/css/tailwind.css` (~40 KiB). In deploy includi questo file (o esegui `npm run build` sul server). Se il file non esiste, il tema carica comunque il CDN.

## Immagine hero

L’immagine `landing-hero-section.png` (~1,8 MiB) è già con `fetchpriority="high"` e preload sulla home. Per ridurre ulteriormente il peso considera:

- Conversione in **WebP** (o AVIF) con fallback
- Ridimensionamento se le dimensioni effettive sono minori di 1200×630

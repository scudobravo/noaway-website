# NoAway API

L’app Electron invia **attivazioni** e **validazioni (con statistiche)** via POST; i dati vengono scritti sullo **stesso MySQL** del sito WordPress.

## Posizione

L’API è dentro il progetto WordPress:

```
website/wordpress/
├── api/              ← qui (montata in Docker in /var/www/html/api)
│   ├── activate.php
│   ├── validate.php
│   ├── config.php
│   ├── db.php
│   ├── licenseKey.php
│   ├── rateLimit.php
│   ├── schema.sql
│   ├── .htaccess
│   └── README.md
├── wp-content/
├── docker-compose.yml
└── ...
```

## Locale (Docker)

- WordPress: **http://localhost:19090**
- API: **http://localhost:19090/api/activate** e **http://localhost:19090/api/validate**

`docker-compose.yml` monta `./api` in `/var/www/html/api`, quindi le modifiche in `website/wordpress/api/` sono subito attive nel container.

## Configurazione

- **config.php** legge le credenziali da **wp-config.php** (stesso DB WordPress). In Docker wp-config viene creato dall’immagine/install; la path `../wp-config.php` dalla cartella `api` punta alla root del sito.
- Esegui **schema.sql** una volta sul database (es. tramite phpMyAdmin su localhost:33071 o `mysql` nel container).

## URL per l’app Electron

- In locale: `http://localhost:19090/api` (poi POST a `/activate` e `/validate`).
- In produzione: `https://noaway.app/api`.

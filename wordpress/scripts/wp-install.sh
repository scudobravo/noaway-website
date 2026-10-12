#!/usr/bin/env bash
# Installa WordPress via wp-cli e attiva il tema NoAway.
# Esegui dopo: docker compose up -d (attendi ~30s che MySQL sia pronto).

set -e
cd "$(dirname "$0")/.."
WP_URL="${WP_HOME:-http://localhost:19090}"
WP_TITLE="${WP_TITLE:-NoAway}"
WP_USER="${WP_USER:-admin}"
WP_PASS="${WP_PASS:-admin}"
WP_EMAIL="${WP_EMAIL:-admin@noaway.app}"

echo "→ WordPress URL: $WP_URL"
echo "→ Attendo che MySQL sia pronto..."
until docker compose exec -T db mysqladmin ping -h localhost -u root -prootpassword --silent 2>/dev/null; do
  echo "   In attesa di MySQL..."
  sleep 3
done
echo "   MySQL ok."

echo "→ Attendo che WordPress abbia scritto wp-config.php nel volume..."
until docker compose exec -T wpcli test -f /var/www/html/wp-config.php 2>/dev/null; do
  echo "   In attesa di wp-config.php..."
  sleep 2
done
echo "   wp-config.php ok."

echo "→ Verifica connessione DB da wp-cli..."
if ! docker compose exec -T wpcli wp db query "SELECT 1" --path=/var/www/html --allow-root; then
  echo "   Se l'errore persiste, riavvia i container: docker compose down && docker compose up -d"
  exit 1
fi

WP="docker compose exec -T wpcli wp --path=/var/www/html --allow-root"
if $WP core is-installed 2>/dev/null; then
  echo "→ WordPress già installato. Aggiorno URL e tema."
  $WP option update home "$WP_URL" 2>/dev/null || true
  $WP option update siteurl "$WP_URL" 2>/dev/null || true
else
  echo "→ Installazione WordPress..."
  $WP core install \
    --url="$WP_URL" \
    --title="$WP_TITLE" \
    --admin_user="$WP_USER" \
    --admin_password="$WP_PASS" \
    --admin_email="$WP_EMAIL" \
    --skip-email
fi

echo "→ Attivazione tema noaway-theme..."
$WP theme activate noaway-theme

echo "→ Impostazione homepage (front page)..."
$WP option update show_on_front page 2>/dev/null || true
$WP option update page_on_front 0 2>/dev/null || true

echo ""
echo "Fatto. Apri: $WP_URL"
echo "Admin: $WP_URL/wp-admin (user: $WP_USER, password: $WP_PASS)"
echo ""

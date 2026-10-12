#!/usr/bin/env bash
# Esegue wp-cli nel container wpcli. Uso: ./scripts/wp-cli.sh <comando> [argomenti]
# Es: ./scripts/wp-cli.sh plugin list
#     ./scripts/wp-cli.sh option get siteurl

set -e
cd "$(dirname "$0")/.."
docker compose exec wpcli wp --path=/var/www/html --allow-root "$@"

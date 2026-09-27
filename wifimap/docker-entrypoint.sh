#!/bin/sh
set -eu
if [ -n "${google_maps_api_key:-}" ]; then
    printf 'googleMapsJavascriptAPIKey = "%s";\n' "$google_maps_api_key" > /var/www/html/js/API_key.js
fi
exec docker-php-entrypoint "$@"

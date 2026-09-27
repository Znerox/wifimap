   #!/bin/sh
   set -eu
   if [ -n "${GOOGLE_MAPS_API_KEY:-}" ]; then
       printf 'googleMapsJavascriptAPIKey = "%s";\n' "$GOOGLE_MAPS_API_KEY" > /var/www/html/js/API_key.js
   fi
   exec docker-php-entrypoint "$@"

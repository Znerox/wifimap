#!/bin/sh -e

sed -i "s/YOUR_API_KEY/${api_key}/g" index.html
sed -i "s/YOUR_API_KEY/${api_key}/g" js/API_key.js

docker-php-entrypoint apache2-foreground

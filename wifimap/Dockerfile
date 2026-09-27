FROM php:8.4-apache
# Production ini: display_errors=Off etc. Without it the image runs with
# PHP's built-in defaults, and a deprecation notice would corrupt the XML
# responses the frontend parses.
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && docker-php-ext-install mysqli
COPY . /var/www/html/
RUN install -d -o www-data -g www-data -m 755 /var/www/html/tools/php/uploads
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod 755 /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]

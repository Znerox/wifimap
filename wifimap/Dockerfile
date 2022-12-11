FROM php:8.1-apache
COPY . /var/www/html/
COPY init.sh /init.sh
RUN chmod -R 777 /var/www/html/tools/php/uploads
RUN docker-php-ext-install mysqli
ENTRYPOINT ["/init.sh"]

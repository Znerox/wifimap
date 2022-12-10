FROM php:8.1-apache
COPY . /var/www/html/
RUN chmod -R 777 /var/www/html/tools/php/uploads
RUN docker-php-ext-install mysqli

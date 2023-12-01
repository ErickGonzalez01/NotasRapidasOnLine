FROM php:8.0-apache
COPY . /var/www/html/

ENV APACHE_DOCUMENT_ROOT /var/www/html/public/
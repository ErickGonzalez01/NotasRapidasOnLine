FROM php:8.0-apache
COPY . /var/www/

RUN apt-get update
RUN apt-get intall nano
#ENV APACHE_DOCUMENT_ROOT /var/www/public

#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' ##/etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN rm /etc/apache2/sites-available/000-default.conf

COPY 000-default.conf /etc/apache2/sites-available/
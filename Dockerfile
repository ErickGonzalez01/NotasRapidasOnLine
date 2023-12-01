FROM php:8.0-apache
COPY . /var/www/html/
WORKDIR /var/www/html/

RUN sed -i 's/DocumentRoot\ \/var\/www\/html/DocumentRoot\ \/var\/www\/html\/public/g' /etc/apache2/httpd.conf
RUN service apache2 restart




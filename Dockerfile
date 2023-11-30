FROM php
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

CMD [ "php", "spark", "serve" ]


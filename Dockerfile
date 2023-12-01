FROM php:8.2-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp

CMD ["sh", "-c", "php spark migrate && php spark serve"]

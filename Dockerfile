FROM php:8.1-fpm-alpine

RUN apk --update --no-cache add git bash openssh shadow
RUN docker-php-ext-install pdo_mysql

RUN mkdir ~/.ssh/

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/payment-project

CMD composer install ; php-fpm

EXPOSE 9000
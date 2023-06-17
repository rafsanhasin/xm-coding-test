FROM php:8.3-rc-fpm

RUN apt-get update

RUN apt-get install -y nano curl zip libpq-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

RUN mkdir -p /var/logs/xm-test

CMD [ "php-fpm" ]

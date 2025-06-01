FROM php:8.3-cli

RUN apt update \
    && apt install -y unzip zip libzip-dev

RUN docker-php-ext-install bcmath zip

RUN pecl install xdebug-3.4.3 \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD ["php"]

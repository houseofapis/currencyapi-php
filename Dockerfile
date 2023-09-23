ARG VERSION=7.4
FROM php:$VERSION-alpine
ARG APP_DIR=/application
WORKDIR $APP_DIR

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY composer.json $APP_DIR/

RUN composer install
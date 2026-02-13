ARG VERSION=8.5
FROM php:$VERSION-alpine
ARG APP_DIR=/application
WORKDIR $APP_DIR

RUN apk --no-cache add pcre-dev linux-headers ${PHPIZE_DEPS} \ 
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && apk del pcre-dev linux-headers ${PHPIZE_DEPS}
  
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY composer.json $APP_DIR/

RUN composer install
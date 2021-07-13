FROM php:7.4-cli-alpine

ARG COMPOSER_VERSION=2.1.2

# Install composer
RUN wget -O /usr/local/bin/composer https://github.com/composer/composer/releases/download/$COMPOSER_VERSION/composer.phar && \
    chmod +x /usr/local/bin/composer

COPY . /app

WORKDIR /app

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

CMD ["php", "updater.php"]
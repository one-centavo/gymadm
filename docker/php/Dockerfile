
FROM composer:2.10 AS vendor
WORKDIR /app


COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --no-scripts \
    --no-autoloader

COPY database/ database/
COPY app/ app/
COPY routes/ routes/


RUN composer dump-autoload --optimize --no-dev --classmap-authoritative


FROM node:22-alpine AS frontend
WORKDIR /app

RUN apk add --no-cache make g++ python3 \
    && npm install -g pnpm

COPY package.json pnpm-lock.yaml* vite.config.js ./

RUN pnpm config set package-import-method copy \
    && pnpm install --frozen-lockfile

COPY resources/ resources/
COPY public/ public/
COPY app/ app/

RUN pnpm run build


FROM php:8.3-fpm-alpine

FROM node:22-alpine AS frontend
WORKDIR /app


RUN apk add --no-cache \
        unzip \
        curl \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        oniguruma-dev \
        libxml2-dev \
        icu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        zip \
        bcmath \
        opcache \
        gd \
        mbstring \
        exif \
        pcntl

RUN adduser -G www-data -u ${uid} -h /home/${user} -D ${user}

WORKDIR /var/www/html


COPY --chown=${user}:www-data . .
COPY --from=vendor --chown=${user}:www-data /app/vendor/ ./vendor/
COPY --from=frontend --chown=${user}:www-data /app/public/build/ ./public/build/

RUN mkdir -p storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R ${user}:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

USER ${user}

CMD ["php-fpm"]
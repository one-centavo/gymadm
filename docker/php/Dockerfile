FROM composer:2.10 AS vendor
WORKDIR /app

COPY database/ database/
COPY app/ app/
COPY routes/ routes/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --optimize-autoloader \
    --no-scripts

FROM node:22-alpine AS frontend
WORKDIR /app

RUN apk add --no-cache make g++ python3 \
    && npm install -g pnpm

COPY package.json pnpm-lock.yaml* vite.config.js ./

RUN pnpm config set package-import-method copy \
    && pnpm install --ignore-scripts=false

COPY resources/ resources/
COPY public/ public/
COPY app/ app/ 

RUN pnpm run build

FROM php:8.3-fpm-alpine

ARG user
ARG uid

RUN apk add --no-cache unzip libzip-dev curl \
    && docker-php-ext-install pdo_mysql zip bcmath opcache

RUN adduser -G www-data -u ${uid:-1000} -h /home/${user:-laravel_user} -D ${user:-laravel_user}

WORKDIR /var/www/html

COPY . .

COPY --from=vendor /app/vendor/ ./vendor/
COPY --from=frontend /app/public/build/ ./public/build/

RUN mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache

RUN chown -R ${user:-laravel_user}:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

EXPOSE 9000

USER ${user:-laravel_user}

CMD ["php-fpm"]
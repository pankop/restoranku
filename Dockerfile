# Stage 1: Composer build
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 2: Application
FROM dunglas/frankenphp:php8.4-alpine
WORKDIR /app

RUN docker-php-ext-install pdo_mysql pcntl

# FIX 1: Salin biner Composer dari stage pertama
COPY --from=vendor /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Copy vendor from previous stage
COPY --from=vendor /app/vendor /app/vendor

# FIX 2: Jalankan dump-autoload (sekarang 'composer' sudah ada)
RUN composer dump-autoload --optimize --no-dev

# Pastikan storage dan cache punya permission
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Optimization (skip error jika .env belum tersedia)
RUN php -r "file_exists('.env') || copy('.env.example', '.env');" \
    && php artisan key:generate --force \
    && php artisan optimize || true

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=frankenphp", "--host=0.0.0.0", "--port=8000"]

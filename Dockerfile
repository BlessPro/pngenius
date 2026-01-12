FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies first for better layer caching
COPY composer.json composer.lock /var/www/
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy your Laravel app
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 8000

CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan migrate --force && \
    php artisan storage:link && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8000}

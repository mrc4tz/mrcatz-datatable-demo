FROM php:8.3-cli

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip curl zip libpng-dev libonig-dev libxml2-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring gd zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first for caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy everything
COPY . .

# Finish composer
RUN composer dump-autoload --optimize

# Build frontend
RUN npm install && npm run build && rm -rf node_modules

# Setup Laravel
RUN cp .env.example .env \
    && touch database/database.sqlite \
    && sed -i 's/DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env \
    && sed -i 's|# DB_DATABASE=.*|DB_DATABASE=/app/database/database.sqlite|' .env \
    && php artisan key:generate \
    && php artisan migrate --seed --force \
    && php artisan config:cache \
    && php artisan view:cache \
    && chmod -R 777 storage bootstrap/cache database

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=8080

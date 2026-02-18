# ================================
# Builder
# ================================
FROM php:8.4-cli AS builder

# Install PHP deps
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libpng-dev libonig-dev libcurl4-openssl-dev \
    && docker-php-ext-install intl zip mbstring pdo pdo_mysql bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*


# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./
# RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy PHP dependencies
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts


# ------------------------------
# Node + Vite for frontend assets
# ------------------------------
# Install Node.js (needed for Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copy Node package files
COPY package.json package-lock.json ./

# Install JS dependencies
RUN npm install

# Copy the rest of your app
COPY . .

# Build production assets
RUN npm run build


# ================================
# Runtime
# ================================
FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libpng-dev libonig-dev libcurl4-openssl-dev \
    && docker-php-ext-install intl zip mbstring pdo pdo_mysql bcmath \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite headers
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html

#COPY . .
# COPY --from=builder /app/vendor ./vendor
# COPY --from=builder /app/public/build ./public/build   # suppress vite error
COPY --from=builder /app ./

RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
# CMD ["apache2-foreground"]

#run migrations, cahce clear and other stuff here as can not use Render.com paid post-deploy command/hook 
CMD sh -c "
echo 'Clearing Laravel caches...' &&

php artisan config:clear &&
php artisan cache:clear &&
php artisan route:clear &&
php artisan view:clear &&

echo 'Rebuilding Laravel caches...' &&

php artisan config:cache &&
php artisan route:cache &&
php artisan view:cache &&

echo 'Running database migrations...' &&
php artisan migrate --force || true &&

echo 'Starting Apache...' &&
apache2-foreground
"


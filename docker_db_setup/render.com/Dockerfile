# ================================
# Builder
# ================================
FROM php:8.4-cli AS builder

# Install PHP deps
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev libpng-dev libonig-dev libcurl4-openssl-dev \
    && docker-php-ext-install intl zip mbstring pdo pdo_mysql bcmath pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy only composer files first (better caching)
COPY composer.json composer.lock ./

# RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy PHP dependencies
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# ------------------------------
# Node + Vite for frontend assets
# ------------------------------
# Install Node.js (needed for Vite)
# (Using official node image binaries instead of curl installer for speed)
COPY --from=node:20-alpine /usr/local/bin/node /usr/local/bin/node
COPY --from=node:20-alpine /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Copy Node package files
COPY package.json package-lock.json ./

# Install JS dependencies (faster + deterministic)
RUN npm ci

# Copy the rest of your app
COPY . .

# Build production assets
RUN npm run build


# ================================
# Runtime
# ================================
FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libonig-dev libcurl4-openssl-dev \
    && docker-php-ext-install intl zip mbstring pdo pdo_mysql bcmath pcntl \
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

#run migrations, cache clear, horizon for jobs and other stuff here as can not use Render.com paid post-deploy command/hook 
CMD sh -c "php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force || true && php artisan horizon & apache2-foreground"
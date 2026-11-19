# Stage 1: Build Frontend Assets (Vite + Tailwind CSS)
FROM node:20-alpine AS frontend-builder

WORKDIR /app

COPY package*.json vite.config.js ./
COPY postcss.config.* tailwind.config.* ./
COPY resources/ ./resources/

RUN npm ci --no-audit --no-fund || npm install --no-audit --no-fund
RUN npm run build

# Stage 2: PHP 8.3 FPM + Nginx + Supervisor
FROM php:8.3-fpm-bookworm

# Install dependensi sistem & ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        zip \
        opcache \
    && rm -rf /var/lib/apt/lists/*

# Install Composer dari official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Salin seluruh kode aplikasi
COPY . .

# Install dependensi PHP produksi
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Salin hasil build aset frontend dari Stage 1
COPY --from=frontend-builder /app/public/build ./public/build

# Salin konfigurasi Nginx, PHP, Supervisor, dan Entrypoint
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/nginx.conf /etc/nginx/sites-enabled/default
COPY docker/php.ini /usr/local/etc/php/conf.d/99-ppid.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

# Pastikan PHP-FPM mempertahankan environment variables dari container
RUN printf "[www]\nclear_env = no\n" > /usr/local/etc/php-fpm.d/zz-clear-env.conf \
    && sed -i 's/\r$//' /usr/local/bin/entrypoint.sh \
    && chmod +x /usr/local/bin/entrypoint.sh \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

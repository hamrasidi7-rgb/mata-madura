FROM php:8.4-cli

RUN apt-get update && apt-get install -y git unzip libzip-dev libpng-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js sebelum COPY agar layer ini ter-cache meski kode berubah
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

# Generate public/build/manifest.json untuk Vite + Tailwind CSS
RUN npm ci && npm run build

EXPOSE 8080
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]

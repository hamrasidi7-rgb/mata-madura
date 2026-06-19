FROM php:8.4-cli
RUN apt-get update && apt-get install -y git unzip libzip-dev libpng-dev libonig-dev curl \
    && docker-php-ext-install pdo pdo_mysql zip mbstring bcmath gd
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs
RUN npm ci && npm run build
EXPOSE 8080
CMD php -S 0.0.0.0:${PORT:-8080} -t public server.php

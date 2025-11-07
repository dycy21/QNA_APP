# 1. Start from a reliable PHP base image (e.g., PHP 8.3 FPM from Docker Hub)
FROM php:8.3-fpm-alpine

# 2. Install necessary system packages, including Node.js and NPM
#    and common extensions needed for Laravel/Composer

RUN apk add --no-cache \
    nginx \
    git \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    postgresql-dev \
    mysql-client \
    && docker-php-ext-install pdo_mysql opcache bcmath exif \
    # Clean up cache
    && rm -rf /var/cache/apk/*

# 3. Set the working directory to /app
WORKDIR /app

# 4. Copy composer files and install PHP dependencies (using Composer)
#    This speeds up rebuilds since composer.json rarely changes
COPY composer.json composer.lock 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# 5. Copy the entire application source code
COPY . .

# 6. Run the combined build command (The one that was failing!)
#    Now, NPM and PHP are guaranteed to be in the path.
RUN npm install \
    && npm run build \
    && php artisan optimize:clear \
    && php artisan migrate --force

# 7. Set correct permissions for storage and cache directories
RUN chmod -R 777 storage bootstrap/cache

# 8. Configure Nginx to serve the Laravel application from the public directory
COPY docker-config/nginx.conf /etc/nginx/conf.d/default.conf

# 9. Expose the port Nginx will listen on
EXPOSE 8000

# 10. Define the start command to run PHP-FPM and Nginx
COPY docker-config/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
CMD [start.sh]
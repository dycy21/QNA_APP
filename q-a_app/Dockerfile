# 1. Start from a reliable PHP-FPM base image
FROM php:8.3-fpm-alpine

# 2. Install dependencies, Nginx, Node.js/NPM, and PHP extensions
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
    && rm -rf /var/cache/apk/*

# 3. Set the working directory
WORKDIR /app

# 4. Copy Composer files and install PHP dependencies
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

# 5. Copy the entire application source code
COPY . .

# 6. RUN the combined build command (NPM and Artisan)
RUN npm install \
    && npm run build \
    && php artisan optimize:clear \
    && php artisan migrate --force

# 7. Set correct permissions
RUN chmod -R 777 storage bootstrap/cache

# 8. EMBED NGINX CONFIGURATION
# Use the 'RUN' instruction with 'echo' and 'cat' to create the nginx.conf file inside the image.
RUN echo "server {" > /etc/nginx/conf.d/default.conf \
    && echo "    listen 8000;" >> /etc/nginx/conf.d/default.conf \
    && echo "    root /app/public;" >> /etc/nginx/conf.d/default.conf \
    && echo "    index index.php index.html;" >> /etc/nginx/conf.d/default.conf \
    && echo "    server_name _;" >> /etc/nginx/conf.d/default.conf \
    && echo "    location / {" >> /etc/nginx/conf.d/default.conf \
    && echo "        try_files \$uri \$uri/ /index.php?\$query_string;" >> /etc/nginx/conf.d/default.conf \
    && echo "    }" >> /etc/nginx/conf.d/default.conf \
    && echo "    location ~ \\.php\$ {" >> /etc/nginx/conf.d/default.conf \
    && echo "        fastcgi_pass 127.0.0.1:9000;" >> /etc/nginx/conf.d/default.conf \
    && echo "        fastcgi_index index.php;" >> /etc/nginx/conf.d/default.conf \
    && echo "        include fastcgi_params;" >> /etc/nginx/conf.d/default.conf \
    && echo "        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;" >> /etc/nginx/conf.d/default.conf \
    && echo "        fastcgi_param PATH_INFO \$fastcgi_path_info;" >> /etc/nginx/conf.d/default.conf \
    && echo "    }" >> /etc/nginx/conf.d/default.conf \
    && echo "}" >> /etc/nginx/conf.d/default.conf

# 9. EMBED STARTUP SCRIPT LOGIC
# The final CMD will execute the two server processes directly.

# 10. Expose the port Nginx will listen on
EXPOSE 8000

# 11. Define the start command to run PHP-FPM and Nginx
# Run PHP-FPM in the background and Nginx in the foreground.
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
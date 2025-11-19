#!/usr/bin/env bash
composer install --prefer-dist --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
php artisan storage:link
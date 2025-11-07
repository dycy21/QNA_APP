#!/bin/sh

# Ensure the log file directory exists and has permissions
mkdir -p /var/log/nginx
chmod 777 /var/log/nginx

# Start PHP-FPM in the background
/usr/local/sbin/php-fpm -D

# Start Nginx in the foreground (required by Docker)
exec nginx -g "daemon off;"
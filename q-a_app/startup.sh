#!/bin/sh
# File: startup.sh

# Start PHP-FPM in the background (-D)
/usr/local/sbin/php-fpm -D

# Start Nginx in the foreground (required by Docker)
exec nginx -g "daemon off;"
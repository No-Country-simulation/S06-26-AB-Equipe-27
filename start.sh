#!/bin/sh
set -eux

cd /var/www/html

echo "Starting Laravel..."

php artisan package:discover --ansi
php artisan migrate --force || true
php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting PHP-FPM..."

/usr/local/sbin/php-fpm -F &
sleep 2

echo "Checking PHP-FPM..."

ps aux | grep php

echo "Starting Nginx..."

exec nginx -g "daemon off;"
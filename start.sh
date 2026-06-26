#!/bin/sh
set -e
cd /var/www/html
echo "Starting Laravel..."
php artisan package:discover --ansi
php artisan migrate --force || true
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php-fpm -D nginx -g "daemon off;"
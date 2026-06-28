#!/bin/sh

set -e

cd /var/www/html

echo "Running Laravel initialization..."

php artisan package:discover --ansi

php artisan migrate --force || true

php artisan storage:link || true

php artisan config:cache

php artisan route:cache

php artisan view:cache

echo "Starting Laravel..."

exec php artisan serve \
    --host=0.0.0.0 \
    --port="${PORT:-10000}"
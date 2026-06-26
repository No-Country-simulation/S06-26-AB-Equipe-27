#!/bin/sh
set -e

echo "PHP executable:"
which php

echo "PHP-FPM executable:"
which php-fpm || true

echo "PHP version:"
php -v

echo "PHP-FPM version:"
php-fpm -v || true

sleep 300
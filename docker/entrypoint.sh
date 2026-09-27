#!/bin/sh

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

php artisan storage:link --force
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate:fresh --force
php artisan db:seed --force

php-fpm -D
nginx -g 'daemon off;'
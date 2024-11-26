#!/bin/sh
set -e

# Выполнение Composer
composer install

# Ожидание базы данных (например, через ping или sleep)
echo "Ожидание подключения к базе данных..."
sleep 5

# Миграции и сидирование
php artisan migrate --force
php artisan db:seed

php artisan storage:link
php artisan optimize

exec php-fpm

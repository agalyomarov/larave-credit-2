FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка рабочей директории и копирование проекта
WORKDIR /var/www/html
COPY ./src /var/www/html

# Установка прав доступа (если необходимо)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Настройка конфигурации PHP-FPM
COPY ./php/php-fpm.conf /usr/local/etc/php-fpm.conf

# Использование entrypoint и запуск PHP-FPM

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chmod +x /var/www/html/entrypoint.sh

ENTRYPOINT ["/var/www/html/entrypoint.sh"]


FROM php:8.4.12-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev
RUN docker-php-ext-install mbstring exif pcntl bcmath gd \
    && docker-php-ext-configure pgsql -with-pgsql \
    && docker-php-ext-install pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . /var/www/

#roots
RUN chown -R www-data:www-data /var/www

RUN composer install
RUN php artisan key:generate

EXPOSE 9000

CMD ["php-fpm"]

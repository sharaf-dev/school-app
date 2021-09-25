FROM php:8.0-apache

# Copy host file
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable a2enmod
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    vim

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install php extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Setup composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN chown -R www-data:www-data app
RUN composer install

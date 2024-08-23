# Base image olarak PHP 8.3 ve Apache kullanan resmi PHP imajını kullanıyoruz
FROM php:8.3-apache
LABEL authors="ahmetcelik"
LABEL description="PHP 8.3 ve Apache tabanlı bir Docker imajı"


# Apache ve PHP uzantılarını yüklemek için gerekli olan paketleri güncelliyoruz
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_pgsql pgsql zip

# Composer (PHP bağımlılık yöneticisi) kurulum
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache mod_rewrite modülünü etkinleştiriyoruz
RUN a2enmod rewrite

# Uygulama dosyalarını kopyalıyoruz
COPY . /var/www/html

# Çalışma dizinini belirliyoruz
WORKDIR /var/www/html

# Gerekli dosya izinlerini ayarlıyoruz
RUN chown -R www-data:www-data /var/www/html

# Apache'yi çalıştırıyoruz
CMD ["apache2-foreground"]

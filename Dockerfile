FROM php:8.3-apache

# Встановлюємо розширення PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Копіюємо налаштування Apache
COPY ./apache-config.conf /etc/apache2/sites-available/000-default.conf

# Налаштування для PHP
COPY ./php.ini /usr/local/etc/php/

# Вмикаємо модуль переписування URL
RUN a2enmod rewrite

# Налаштування прав доступу
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

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

# Налаштування прав доступу
RUN touch /var/www/html/project.log && chown www-data:www-data /var/www/html/project.log && chmod 777 /var/www/html/project.log

RUN pecl install xdebug && docker-php-ext-enable xdebug

EXPOSE 80

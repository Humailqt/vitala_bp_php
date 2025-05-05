FROM php:8.2-apache

# Устанавливаем расширение MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Включаем модуль Apache rewrite
RUN a2enmod rewrite

# Копируем проект внутрь контейнера
COPY . /var/www/html/

# Открываем порт (не обязательно, но можно)
EXPOSE 80

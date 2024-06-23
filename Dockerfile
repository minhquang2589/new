FROM php:8.2.18-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    nginx\
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip\
    redis-tools 

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN echo "upload_max_filesize = 64M" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 64M" >> /usr/local/etc/php/php.ini
RUN apt-get install -y nginx
COPY nginx/default.conf /etc/nginx/conf.d/default.conf
RUN echo "client_max_body_size 64M;" > /etc/nginx/conf.d/default.conf


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /var/www
COPY --chown=www-data:www-data . /var/www
EXPOSE 9000
CMD ["php-fpm"]

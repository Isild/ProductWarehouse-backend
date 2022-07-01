FROM php:8.0-apache

RUN apt-get update \
    && apt-get install -y procps vim \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

COPY docker/apache/sites.conf /etc/apache2/sites-available
RUN a2ensite sites
RUN a2enmod headers rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

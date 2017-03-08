FROM php:7.1.2-apache

MAINTAINER Igor Chepurnoi <chepurnoi.igor@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/www/html"]

ENV DEBIAN_FRONTEND noninteractive

RUN echo Europe/Kiev > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata

RUN apt-get update && apt-get install -y apt-utils
RUN apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libpq-dev \
        git \
        nano \
        zip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install intl zip opcache pdo_mysql

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
    > /usr/local/etc/php/conf.d/xdebug.ini

COPY ./.bashrc /root/.bashrc
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/
RUN echo "LogFormat \"%a %l %u %t \\\"%r\\\" %>s %O \\\"%{User-Agent}i\\\"\" mainlog" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite remoteip

RUN curl -sS -o /root/.bash_aliases https://raw.githubusercontent.com/morontt/dotfiles/master/ubuntu/.bash_aliases

RUN set -x && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require "fxp/composer-asset-plugin:^1.2.0"

RUN usermod -u ${HOST_UID} www-data
RUN groupmod -g ${HOST_UID} www-data

RUN chsh -s /bin/bash www-data
RUN cp /root/.bashrc /var/www
RUN cp /root/.bash_aliases /var/www

EXPOSE 80

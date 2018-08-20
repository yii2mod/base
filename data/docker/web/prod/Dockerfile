FROM php:7.1-apache

MAINTAINER Igor Chepurnoi <chepurnoi.igor@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/www/html"]

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && apt-get install -y apt-utils && apt-get install -y \
        zlib1g-dev \
        libicu-dev \
        libpq-dev \
        git \
        nano \
        zip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        supervisor \
        cron \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install intl zip pdo_mysql

COPY ./.bashrc /root/.bashrc
COPY ./apache.conf /etc/apache2/sites-available/000-default.conf
COPY ./php.ini /usr/local/etc/php/

RUN echo "LogFormat \"%a %l %u %t \\\"%r\\\" %>s %O \\\"%{User-Agent}i\\\"\" mainlog" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite remoteip

RUN set -x && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require hirak/prestissimo --prefer-dist --no-interaction

RUN usermod -u ${HOST_UID} www-data && groupmod -g ${HOST_UID} www-data && chsh -s /bin/bash www-data

RUN cp /root/.bashrc /var/www

# setup cron
ADD ./crontab /etc/cron.d/cron-jobs
RUN chmod 0644 /etc/cron.d/cron-jobs && touch /var/log/cron.log

# setup supervisor
RUN mkdir -p /var/log/supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord"]

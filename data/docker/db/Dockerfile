FROM mysql:5.7

MAINTAINER Igor Chepurnoi <chepurnoi.igor@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/lib/mysql"]

RUN usermod -u ${HOST_UID} mysql

# Setup Mysql character to utf-8
RUN sed -i "/\[mysqld]/a collation-server=utf8_unicode_ci" /etc/mysql/mysql.conf.d/mysqld.cnf
RUN sed -i "/\[mysqld]/a character-set-server=utf8" /etc/mysql/mysql.conf.d/mysqld.cnf

EXPOSE 3306

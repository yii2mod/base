FROM mysql:5.7

MAINTAINER Igor Chepurnoi <chepurnoi.igor@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/lib/mysql"]

RUN usermod -u ${HOST_UID} mysql

EXPOSE 3306

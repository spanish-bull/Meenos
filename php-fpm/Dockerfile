FROM 		php:7.2.11-fpm
LABEL 		maintainer="JeDaTh"

RUN apt-get update && apt-get install -y libicu-dev && apt-get clean
RUN pecl install apcu xdebug
RUN docker-php-ext-enable apcu xdebug
RUN docker-php-ext-install pdo_mysql intl opcache

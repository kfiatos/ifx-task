FROM php:8.3-fpm

RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
        nano \
        procps \
        iputils-ping \
        git \
        ssh \
        curl \
        wget \
        zip \
        unzip

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions \
    && sync \
    && install-php-extensions \
        memcached \
        gd \
        imap \
        intl \
        ldap \
        bcmath \
        bz2 \
        calendar \
        exif \
        gettext \
        mysqli \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        soap \
        sockets \
        xmlrpc \
        xsl \
        pcntl \
        zip \
        xdebug \
        mongodb \
        redis \
        apcu \
        amqp \
        imagick \
        pdo_oci \
        oci8 \
        pdo_odbc \
        odbc \
        sqlsrv \
        pdo_sqlsrv

# COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data/work/app/


FROM php:7.1-fpm

RUN apt update \
    && apt install -y \
        librabbitmq-dev \
        libssh-dev \
    && docker-php-ext-install \
        bcmath \
        sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

# PHP-gd
RUN apt install -y libjpeg-dev libpng-dev libgif-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

# PHP-imagick
RUN apt install -y libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# PHP-mysql
RUN docker-php-ext-install pdo_mysql

# PHP-intl
RUN apt install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# PHP-mcrypt
RUN apt install -y libmcrypt-dev \
    && docker-php-ext-install mcrypt

# PHP-redis
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# PHP-bcmath
RUN docker-php-ext-install bcmath

# PHP-pcntl
RUN docker-php-ext-install pcntl

# PHP-soap
RUN apt install -y libxml2-dev --no-install-recommends \
    && docker-php-ext-install soap

# PHP-zip
RUN docker-php-ext-install zip

# PHP-sockets
RUN docker-php-ext-install sockets

# Install dependencies
RUN apt install -y \
        apt-utils \
        ssh \
        ksh \
        zip \
        git \
        unzip \
        unixodbc-dev \
        curl

# Install PHP odbc extension
RUN set -x \
    && docker-php-source extract \
    && cd /usr/src/php/ext/odbc \
    && phpize \
    && sed -ri 's@^ *test +"\$PHP_.*" *= *"no" *&& *PHP_.*=yes *$@#&@g' configure \
    && ./configure --with-unixODBC=shared,/usr \
    && docker-php-ext-install odbc \
    && docker-php-source delete

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer config --global process-timeout 7200
RUN apt install -y git librabbitmq-dev libssh-dev

# Add configs
COPY php.ini /usr/local/etc/php/
COPY app.pool.conf /usr/local/etc/php-fpm.d/

# Cleanup
RUN rm -rf /var/lib/apt/lists/*

#RUN chmod +x ./bin/hello-worker

WORKDIR /app

ADD . /app

CMD ["php-fpm", "-R"]

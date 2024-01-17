ARG PHP_VERSION

FROM php:${PHP_VERSION}

ARG TZ
ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
        git \
        unzip \
        libzip-dev \
        libicu-dev \
        zlib1g-dev \
        libpq-dev \
        libsodium-dev \
    && rm -rf /var/lib/apt/lists/*

RUN set -xe \
    && docker-php-ext-configure \
        intl \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        pdo_mysql \
        sodium \
        zip

COPY ./php.ini /usr/local/etc/php/php.ini
RUN sed -i -e "s#TIMEZONE#${TZ}#g" /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN usermod -u ${USER_ID} www-data && \
    groupmod -g ${GROUP_ID} www-data

RUN mkdir -p /var/www/.composer && chown www-data:www-data -R /var/www/.composer

WORKDIR /app

USER www-data

CMD ["php-fpm"]

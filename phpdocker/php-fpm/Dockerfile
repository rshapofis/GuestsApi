FROM phpdockerio/php:7.4-fpm
WORKDIR "/guestsApi"

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        git \
        php7.4-mysql \
        curl \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


COPY ./guestsApi /guestsApi

RUN composer install
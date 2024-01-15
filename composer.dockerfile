FROM composer:2

ENV COMPOSERUSER=laravel
ENV COMPOSERGROUP=laravel

RUN adduser -g ${COMPOSERGROUP} -s /bin/sh -D ${COMPOSERUSER}

# Install necessary libraries for intl extension
RUN apk update && apk add --no-cache icu-dev && docker-php-ext-install intl
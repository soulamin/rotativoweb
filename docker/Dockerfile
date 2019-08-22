FROM php:5.6-fpm

## Install Deps
RUN apt-get update && apt-get install -y \
    gnupg \
    curl \
    apt-transport-https \
    lsb-release

## Config Custom repos
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -

RUN \
    apt-get update && \
    apt-get install -y \
    supervisor \
    gcc \
    g++ \
    make \
    nano \
    git \
    npm \
    nodejs \
    yarn \
    mysql-client \
    mcrypt \
    libmcrypt-dev \
    curl \
    libicu-dev \
    libsodium-dev \
    zip \
    libxml2 \
    libc6 \
    libc6-dev \
    libzip-dev \
    && \
    rm -rf /var/lib/apt/lists/*

## Define linguagem
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y locales
RUN sed -i -e 's/# pt_BR.UTF-8 UTF-8/pt_BR.UTF-8 UTF-8/' /etc/locale.gen
RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen
RUN dpkg-reconfigure --frontend=noninteractive locales
ENV LANG pt_BR.UTF-8
ENV LANGUAGE pt_BR.UTF-8
ENV LC_ALL pt_BR.UTF-8

## Define Localtime para UTC-3
RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime

## Instalar PHP Extensions
RUN docker-php-ext-install intl mysql mysqli pdo-mysql bcmath zip exif pcntl
#RUN docker-php-source extract
#RUN pecl install xdebug-2.5.5
#RUN docker-php-ext-enable xdebug
#RUN docker-php-source delete

## Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

## Cria grupo e usuario de trabalho
RUN addgroup -gid 1000 www
RUN useradd -u 1000 -s /bin/bash -g www www

#COPY --chown=www:www . /var/www
RUN mkdir --parent /var/www
RUN chown www:www -R /var/www

USER www

EXPOSE 9000 9001
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
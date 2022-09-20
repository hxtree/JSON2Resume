# syntax=docker/dockerfile:1
#######################################
# Build (Base Image)
#######################################
FROM php:7.4-fpm-buster AS build

ARG ENV=DEV
ARG user=root
ARG group=root

# fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# libpng-dev needed by "gd" extension
# libzip-dev needed by "zip" extension
# libicu-dev for intl extension
RUN apt-get update \
 && apt-get install -y \
  wget \
  gnupg \
  g++ \
  locales \
  unzip \
  dialog \
  apt-utils \
  curl \
  git \
  bash \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  libicu-dev \
  vim \
  dos2unix \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
  mysqli \
  pdo \
  pdo_mysql \
  gd \
  intl \
  opcache \
  zip \
 && echo "UTC" > /etc/timezone \
 && dpkg-reconfigure -f noninteractive tzdata \
 && docker-php-source extract \
  pecl install opcache apcu \
  docker-php-ext-enable \
  opcache \
  apcu \
  pdo_mysql \
  docker-php-source delete \
  rm -rf /tmp/*

WORKDIR /application

# allow webserver to use modify application
RUN chown -R $group:$user /application/

#######################################
# Testing (Development Environment)
#######################################
FROM build AS test

# Install composer and vendor packages
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

# Testing uses bind volume mount
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
 && pecl install xdebug \
 && echo "xdebug.mode=coverage\n" >> "$PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini" \
 && docker-php-ext-enable xdebug \
 && rm -rf /tmp/*

COPY composer.json /application
COPY composer.lock /application

USER $user

#######################################
# Standard (Production Environment)
#######################################
FROM build AS standard

# Install composer and vendor packages
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

COPY . /application

# RUN composer install --no-dev --no-interaction

USER $user


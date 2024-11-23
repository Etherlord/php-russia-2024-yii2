FROM composer:2.8 AS composer
FROM mlocati/php-extension-installer:2.4 AS php-extension-installer
FROM php:8.3-fpm-bookworm AS dev-php

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

ARG UID=10001
ARG GID=10001

RUN <<EOF
  groupmod --gid=${GID} www-data
  usermod --uid=${UID} --gid=${GID} www-data
EOF

RUN <<EOF
  apt-get update
  apt-get install --no-install-recommends --no-install-suggests -q -y \
          unzip \
          libfcgi-bin
EOF

COPY docker/php-fpm/www-json-logs.conf /usr/local/etc/php-fpm.d/www-json-logs.conf
COPY docker/php-fpm/www-status.conf /usr/local/etc/php-fpm.d/www-status.conf
COPY docker/php-fpm/php-fpm-healthcheck /usr/local/bin/php-fpm-healthcheck

RUN <<EOF
  echo "pm=static" >> /usr/local/etc/php-fpm.d/zz-docker.conf
  echo "pm.max_children=10" >> /usr/local/etc/php-fpm.d/zz-docker.conf
EOF

RUN <<EOF
  install-php-extensions opcache
  apt-get remove -q -y \
          ${PHPIZE_DEPS} \
          ${BUILD_DEPENDS}
EOF

WORKDIR /app

RUN chown www-data:www-data /app

RUN <<EOF
  chown www-data:www-data /app
  mkdir -p /app/runtime
  chown www-data:www-data /app/runtime
  mkdir -p /app/runtime/queue
  chown www-data:www-data /app/runtime/queue
EOF

USER www-data

FROM dev-php AS prod-php

USER root

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/conf.d/php.ini

USER www-data

ENV COMPOSER_CACHE_DIR=/tmp/composer/cache

COPY ./composer.json ./composer.lock ./

RUN \
    --mount=type=cache,uid=${UID},gid=${GID},target=/tmp/composer/cache \
    composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-progress --no-interaction

COPY --chown=www-data:www-data ./ ./

RUN \
    --mount=type=cache,uid=${UID},gid=${GID},target=/tmp/composer/cache \
    composer dump-autoload --classmap-authoritative --no-dev
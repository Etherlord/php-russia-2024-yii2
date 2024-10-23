FROM composer:2.8 AS composer
FROM mlocati/php-extension-installer:2.4 AS php-extension-installer
FROM php:8.3-fpm-bookworm AS php-fpm

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
          unzip
EOF

COPY docker/php-fpm/www-json-logs.conf /usr/local/etc/php-fpm.d/www-json-logs.conf

RUN <<EOF
  install-php-extensions opcache
  apt-get remove -q -y \
          ${PHPIZE_DEPS} \
          ${BUILD_DEPENDS}
EOF

WORKDIR /app

RUN chown www-data:www-data /app

USER www-data
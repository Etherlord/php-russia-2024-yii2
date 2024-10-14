FROM nginxinc/nginx-unprivileged:1.27-bookworm

USER root

RUN mkdir -p /app && chown nginx:nginx /app

USER nginx

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app
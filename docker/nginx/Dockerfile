FROM nginxinc/nginx-unprivileged:1.27-bookworm AS dev-nginx

USER root

RUN mkdir -p /app && chown nginx:nginx /app

USER nginx

COPY --chown=nginx docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --chown=nginx docker/nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /app

FROM dev-nginx AS prod-nginx

COPY --chown=nginx:nginx ./ ./
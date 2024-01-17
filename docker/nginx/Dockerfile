ARG NGINX_VERSION

FROM nginx:${NGINX_VERSION}

ADD nginx.conf /etc/nginx/

RUN mkdir -p /var/log/nginx/spa

RUN rm /var/log/nginx/access.log /var/log/nginx/error.log

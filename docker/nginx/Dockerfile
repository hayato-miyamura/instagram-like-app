FROM alpine:3.6

# nginx install
RUN apk update && \
    apk add --no-cache nginx

# document root
ADD default.conf /etc/nginx/conf.d/default.conf

# port
EXPOSE 80

RUN mkdir -p /run/nginx

#
CMD nginx -g "daemon off;"
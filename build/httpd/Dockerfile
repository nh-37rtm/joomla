# -*- coding: utf-8 -*-

FROM httpd:2.4.57-alpine3.17

LABEL authors="Nicolas Béjean <nicolas@bejean.fr>"
LABEL company="Béjean Développement"
LABEL website="www.bejean.eu"
LABEL version="1.0"

# Change port and update server name
RUN sed -i \
    -e 's/Listen 80/Listen 8000/' \
    -e 's/^#ServerName.*/ServerName localhost:8000/' \
    /usr/local/apache2/conf/httpd.conf

# Enable proxy and fcgi modules
RUN sed -i \
    -e 's/^#\(LoadModule proxy_module modules\/mod_proxy.so\)/\1/' \
    -e 's/^#\(LoadModule proxy_fcgi_module modules\/mod_proxy_fcgi.so\)/\1/' \
    /usr/local/apache2/conf/httpd.conf

# Add vhost configuration and copy vhost file
COPY conf/httpd-vhosts.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf
RUN sed -i \
    -e 's/#Include\ conf\/extra\/httpd-vhosts.conf/Include\ conf\/extra\/httpd-vhosts.conf/' \
    /usr/local/apache2/conf/httpd.conf

# Create users, directories and update permissions
RUN addgroup -g 1000 app \
    && adduser -D -H -h /var/www/html -s /sbin/nologin -G app -u 1000 app \
    && mkdir -p /var/www/html /usr/local/apache2/logs \
    && chown -R app:app /var/www/html /usr/local/apache2/logs

# Change owner and group
USER app:app

# Change workdir
WORKDIR /var/www/html

# Expose port 8000
EXPOSE 8000

# Start apache
CMD ["httpd-foreground"]
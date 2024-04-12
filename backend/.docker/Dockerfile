FROM bitnami/laravel:latest
WORKDIR /app

ENV PHP_ENABLE_OPCACHE="0"
ENV ALLOW_EMPTY_PASSWORD=yes
ENV LARAVEL_DATABASE_TYPE=mysql
ENV LARAVEL_DATABASE_HOST=${SERVICE_MYSQL_HOST:-mysql}
ENV LARAVEL_DATABASE_PORT_NUMBER=${SERVICE_MYSQL_PORT:-3306}
ENV LARAVEL_DATABASE_NAME=${SERVICE_MYSQL_NAME:-app}
ENV LARAVEL_DATABASE_USER=${SERVICE_MYSQL_PASS:-app}

RUN apt-get update && apt-get -y install cron supervisor

RUN echo 'extension=xdebug.so' >> /opt/bitnami/php/lib/php.ini

# Add php.ini configuration
RUN echo "opcache.enable=0" >> /opt/bitnami/php/lib/php.ini \
    echo "[xdebug]" >> /opt/bitnami/php/lib/php.ini && \
    echo "xdebug.mode=debug" >> /opt/bitnami/php/lib/php.ini && \
    echo "xdebug.start_with_request=yes" >> /opt/bitnami/php/lib/php.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /opt/bitnami/php/lib/php.ini && \
    echo "xdebug.client_port=9003" >> /opt/bitnami/php/lib/php.ini

COPY start-container /usr/local/bin/start-container
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chmod +x /usr/local/bin/start-container

ENTRYPOINT ["start-container"]

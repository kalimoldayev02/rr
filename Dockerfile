FROM ghcr.io/ikolossov/php-rr-base-image:latest

RUN install-php-extensions gd

ENV RR_CONFIG=.rr.yaml

WORKDIR /app
COPY . .
RUN composer i -o --no-dev

COPY deploy/php/opcache.php.ini /usr/local/etc/php/conf.d/opcache.php.ini

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

RUN chmod +x entrypoint.sh
ENTRYPOINT ["./entrypoint.sh"]

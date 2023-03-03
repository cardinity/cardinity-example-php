FROM php:8.2.3

RUN apt-get update && apt-get install zip unzip -y

# copy the Composer PHAR from the Composer image into the PHP image
COPY --from=composer:2.5.4 /usr/bin/composer /usr/bin/composer

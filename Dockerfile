FROM php:7.4

RUN apt-get update && apt-get install -y libgmp-dev && docker-php-ext-install gmp

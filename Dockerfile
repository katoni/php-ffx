FROM php:7.2

RUN apt-get update && apt-get install -y libgmp-dev && docker-php-ext-install gmp

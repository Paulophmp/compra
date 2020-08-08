FROM php:5.6.19-apache

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpq-dev \
    apt-utils \
    git \
    unzip \
    libbz2-dev \
    libzip-dev \
    zip \
    libaio-dev \
    libxml2-dev \
    && apt-get clean -y

RUN ls -la /tmp \
    && cd /tmp \
    && curl --silent --show-error https://getcomposer.org/installer | php \
    && ls -la /tmp \
    && mv /tmp/composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer \
    && cd /var/www
RUN COMPOSER_MEMORY_LIMIT=-1

RUN docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install soap zip bz2 bcmath pdo_pgsql

RUN apt-get update && apt-get install -y pkg-config patch

#ADD ./freetype.patch /tmp/freetype.patch
#RUN docker-php-source extract; \
#    cd /usr/src/php; \
#    patch -p1 -i /tmp/freetype.patch; \
#    rm /tmp/freetype.patch
#
#RUN apt-get update && apt-get install -y \
#    libfreetype6-dev \
#    libjpeg62-turbo-dev \
#    libpng-dev \
#    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#    && docker-php-ext-install -j$(nproc) gd \
#    && apt-get clean -y

RUN a2enmod rewrite

#CMD ["apache2-foreground"]
ENTRYPOINT ["local-dev.sh"]

EXPOSE 80
#RUN echo "upload_max_filesize = 50M" >> /usr/local/etc/php/php.ini
#RUN echo "post_max_size = 50M" >> /usr/local/etc/php/php.ini
#RUN echo "date.timezone = \"America/Recife\"" >> /usr/local/etc/php/php.ini
#RUN ln -snf /usr/share/zonyeinfo/America/Recife /etc/localtime && echo America/Recife > /etc/timezone
# RUN /usr/share/zoneinfo/America/Sao_Paulo
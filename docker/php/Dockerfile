FROM php:7.2-fpm
 
RUN apt-get update && apt-get install -y \  
        libicu-dev \
    	libpq-dev \
    	git \
    	mariadb-client \
    	nano \
    	gnupg \
        unzip \
        zlib1g-dev \
        libpng-dev \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo \
        pdo_mysql \
        zip \
    && docker-php-ext-enable \
        intl \
        opcache \
        pdo \
        pdo_mysql \
        zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

# Install npm
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
      && apt-get install -y nodejs

RUN usermod -u 1000 www-data
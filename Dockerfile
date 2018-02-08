FROM php:7.1-cli
MAINTAINER Tim Green <tim@totallywicked.co.uk>

# Define BUILD Arguments and Default
ARG m2_publickey=99999
ARG m2_privatekey=99999

# First things first, let's install magento from source
ENV M2_PUBKEY $m2_publickey
ENV M2_PRIVKEY $m2_privatekey

# Run updates and install mysql client
RUN apt-get update -yqq && \
    apt-get install -y \
      git zlib1g-dev libsqlite3-dev mysql-client curl wget \
      libmcrypt-dev libpng-dev libz-dev libxml2-dev libxslt1-dev \
      zlib1g-dev libicu-dev g++ && \
    docker-php-ext-install zip && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo_sqlite && \
    docker-php-ext-install mcrypt && \
    docker-php-ext-install gd && \
    docker-php-ext-install soap && \
    docker-php-ext-install xsl && \
    docker-php-ext-install intl

# Install Composer
RUN curl -fsSL https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer global require phpunit/phpunit ^5.7 --no-progress --no-scripts --no-interaction

# Install XDebug
RUN pecl install xdebug && \
    echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20160303/xdebug.so' > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    php -m | grep xdebug

# Add composer to PATH
ENV PATH /root/.composer/vendor/bin:$PATH

# Create auth.json for Magento 2 Install
# RUN echo "{\"http-basic\":{\"repo.magento.com\":{\"username\":\"${MAGENTO_USERNAME}\",\"password\":\"${MAGENTO_PASSWORD}\"}}}" > auth.json
RUN composer global config http-basic.repo.magento.com $M2_PUBKEY $M2_PRIVKEY

# Install n98-magerun2
RUN wget https://files.magerun.net/n98-magerun2.phar && \
    mv n98-magerun2.phar /usr/local/bin/n98-magerun && \
    chmod 777 /usr/local/bin/n98-magerun && \
    ln -nsf /usr/local/bin/n98-magerun /usr/local/bin/mr2

FROM php:7.1
MAINTAINER Tim Green <tim@totallywicked.co.uk>

# First things first, let's install magento from source
ENV M2_PUBKEY="d3e6699252049f4784140b0458f718c0"
ENV M2_PRIVKEY="10d0b46f8b4a6482b26882739111a18f"
ENV MYSQL_HOST="mysql"
ENV MYSQL_DATABASE="magento2"
ENV MYSQL_USERNAME="magento2"
ENV MYSQL_PASSWORD="magento2"

RUN apt-get update && apt-get install -y \
  cron \
  libfreetype6-dev \
  libicu-dev \
  libjpeg62-turbo-dev \
  libmcrypt-dev \
  libpng12-dev \
  libxslt1-dev \
  mysql-client \
  wget \
  curl \
  zip \
  git

RUN docker-php-ext-configure \
  gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install \
  bcmath \
  gd \
  intl \
  mbstring \
  mcrypt \
  opcache \
  pdo_mysql \
  soap \
  xsl \
  zip

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
RUN echo "{\"http-basic\":{\"repo.magento.com\":{\"username\":\"${MAGENTO_USERNAME}\",\"password\":\"${MAGENTO_PASSWORD}\"}}}" > /root/.composer/auth.json
RUN composer global config http-basic.repo.magento.com $M2_PUBKEY $M2_PRIVKEY

# Install n98-magerun2
RUN wget https://files.magerun.net/n98-magerun2.phar && \
    mv n98-magerun2.phar /usr/local/bin/n98-magerun && \
    chmod 777 /usr/local/bin/n98-magerun && \
    ln -nsf /usr/local/bin/n98-magerun /usr/local/bin/mr2

# Now install an instance of Magento 2
RUN mkdir -p /builds/magento2 && \
    composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition /builds/magento2 && \
    cd /builds/magento2 && \
    find . -type d -exec chmod 700 {} \; && find . -type f -exec chmod 600 {} \;
#    php bin/magento setup:install --base-url="http://yoururl.com/" --db-host=${MYSQL_HOST} --db-name=${MYSQL_DATABASE} --db-user=${MYSQL_USERNAME} --db-password=${MYSQL_PASSWORD} --admin-firstname="admin" --admin-lastname="admin" --admin-email="user@example.com" --admin-user="admin" --admin-password="admin123" --language="en_US" --currency="USD" --timezone="America/Chicago" --use-rewrites="1" --backend-frontname="admin"

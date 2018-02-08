FROM epcallan/php7-testing-phpunit:7.1-phpunit5
MAINTAINER Tim Green <tim@totallywicked.co.uk>

# Define BUILD Arguments and Default
ARG m2_publickey=99999
ARG m2_privatekey=99999
ARG m2_dbhost=mysql
ARG m2_dbuser=mysql
ARG m2_dbpass=mysql
ARG m2_dbname=mysql
ARG m2_version=magento-ce-2.2.2

# First things first, let's install magento from source
ENV M2_PUBKEY $m2_publickey
ENV M2_PRIVKEY $m2_privatekey
ENV DB_HOST $m2_dbhost
ENV DB_USER $m2_dbuser
ENV DB_PASS $m2_dbpass
ENV DB_NAME $m2_dbname
ENV MAGENTO2_VERSION $m2_version

# Run updates and install mysql client
RUN apt-get update -yqq && \
    apt-get -y upgrade && \
    apt-get install -y \
                          mysql-client \
                          curl wget \
                          libmcrypt-dev \
                          libpng-dev \
                          libz-dev \
                          libxml2-dev \
                          libxslt1-dev \
                          zlib1g-dev \
                          libicu-dev \
                          g++ && \
    docker-php-ext-install mcrypt && \
    docker-php-ext-install gd && \
    docker-php-ext-install soap && \
    docker-php-ext-install xsl && \
    docker-php-ext-install intl

# Create auth.json for Magento 2 Install
# RUN echo "{\"http-basic\":{\"repo.magento.com\":{\"username\":\"${MAGENTO_USERNAME}\",\"password\":\"${MAGENTO_PASSWORD}\"}}}" > auth.json
RUN composer global config http-basic.repo.magento.com $M2_PUBKEY $M2_PRIVKEY

# Install n98-magerun2
RUN wget https://files.magerun.net/n98-magerun2.phar && \
    mv n98-magerun2.phar /usr/local/bin/n98-magerun && \
    chmod 777 /usr/local/bin/n98-magerun && \
    ln -nsf /usr/local/bin/n98-magerun /usr/local/bin/mr2

# Now we have the auth, let's install M2 base system
RUN mkdir /builds && \
    mr2 install \
      --dbHost=$DB_HOST \
      --dbUser=$DB_USER \
      --dbPass=$DB_PASS \
      --dbName=$DB_NAME \
      --installSampleData=yes \
      --useDefaultConfigParams=yes \
      --magentoVersionByName=$MAGENTO2_VERSION \
      --installationFolder="/builds/magento2" \
      --baseUrl="http://magento2.localdomain/"

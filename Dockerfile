FROM epcallan/php7-testing-phpunit:7.1-phpunit5
MAINTAINER Tim Green <tim@totallywicked.co.uk>

# First things first, let's install magento from source
ENV M2_PUBKEY d3e6699252049f4784140b0458f718c0
ENV M2_PRIVKEY 10d0b46f8b4a6482b26882739111a18f
ENV DB_HOST mysql
ENV DB_USER magento2
ENV DB_PASS magento2
ENV DB_NAME trustpilot_widgets
ENV MAGENTO2_VERSION magento-ce-2.2.2

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

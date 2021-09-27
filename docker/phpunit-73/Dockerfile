FROM ubuntu:20.04
#FROM debian:9

WORKDIR /app

RUN apt update --fix-missing

#------------------------------------------------------------------------------
# Install common tools
# software-properties-common -
#         -> for Dockerfile [add-apt-repository; apt-add-repository]
# curl    - many tasks for dowload files
# make    ->
# zip     ->
# unzip   ->
#         - for pecl
# gnupg2                      ->
# software-properties-common  ->
#         - for MSSQL, add "microsoft.asc"
# unixodbc-dev   - for MSSQL
# lsof - used in integration tests
#      @see: test/integration/Adapter/Driver/Pdo/AbstractAdapterTest.php function isConnectedTcp
#      @example: lsof -i -P -n | grep 3306 | grep 1
#----

RUN echo "--- Install common tools" \
    && DEBIAN_FRONTEND=noninteractive apt install -y \
    software-properties-common \
    curl \
    make \
    zip \
    unzip \
    gnupg2 \
    unixodbc-dev \
    lsof \
    sqlite

#------------------------------------------------------------------------------
# Install PHP-CLI, PHP-extensions, php-composer
# php-dev php-pear -  for pecl install ...
# @see: https://prototype.php.net/versions/7.3/install/
#-----


RUN echo "---add php 7.3 repo (ubuntu 20.04)" \
    && add-apt-repository ppa:ondrej/php

RUN apt-get update --fix-missing

RUN echo "---install PHP [CLI, DEV]" \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    php7.3-cli \
    php7.3-dev

RUN DEBIAN_FRONTEND=noninteractive apt-get install -y php-pear

RUN echo "---install PHP extensions" \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    php7.3-common \
    php7.3-bcmath php7.3-bz2 php7.3-curl php7.3-dba php7.3-gd php7.3-imap \
    php7.3-intl php7.3-json php7.3-mbstring php7.3-mysql php7.3-odbc \
    php7.3-opcache php7.3-pgsql php7.3-snmp php7.3-soap \
    php7.3-tidy php7.3-xml php7.3-zip

# php7.3-sqllite3 - WTF? @see: https://prototype.php.net/versions/7.3/install/
## E: Unable to locate package php7.3-sqllite3
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y php7.3-sqlite3

# php7.3-xls - WTF? @see: https://prototype.php.net/versions/7.3/install/
## E: Unable to locate package php7.3-xls
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y php7.4-xsl


RUN echo "---install PHP extensions from vendors" \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    php7.3-xdebug \
    php7.3-xhprof

# Install PHP composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#------------------------------------------------------------------------------
# Install MSSQL client
# @see: https://docs.microsoft.com/en-us/sql/connect/odbc/download-odbc-driver-for-sql-server?view=sql-server-ver15
# @see: https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-ver15
#-----

RUN curl -s https://packages.microsoft.com/keys/microsoft.asc --output microsoft.asc
RUN apt-key add microsoft.asc

RUN curl -s https://packages.microsoft.com/config/ubuntu/20.04/mssql-server-2019.list --output /etc/apt/sources.list.d/mssql-server-2019.list
RUN curl -s https://packages.microsoft.com/config/ubuntu/20.04/prod.list --output /etc/apt/sources.list.d/mssql-server-2019.list
#RUN repoargs="$(curl https://packages.microsoft.com/config/ubuntu/20.04/mssql-server-2019.list)"
#RUN add-apt-repository "${repoargs}"
#RUN repoargs="$(curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list)"
#RUN add-apt-repository "${repoargs}"
RUN apt-get -yq update

RUN pecl install sqlsrv
RUN printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/7.3/cli/conf.d/sqlsrv.ini

RUN pecl install pdo_sqlsrv
RUN printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/7.3/cli/conf.d/pdo_sqlsrv.ini

RUN ACCEPT_EULA=Y apt-get install -y msodbcsql17
RUN ACCEPT_EULA=Y apt-get install -y mssql-tools \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc
#------------------------------------------------------------------------------
# Install Oracle client
# @TODO: install oci8 for Oracle
#-----
#RUN bash install-oracle-client.sh

#------------------------------------------------------------------------------
# Clean a created image
#----

RUN rm -rfv ./*

#------------------------------------------------------------------------------
# Make config links
# We copy all at end of the Dockerfile for using cache of previous operation
#---

# Make link for XDebug's config
COPY 20-xdebug.ini.sample 20-xdebug.ini
RUN ln -sfv `pwd`/20-xdebug.ini /etc/php/7.3/cli/conf.d/20-xdebug.ini

#------------------------------------------------------------------------------
# Print info about result
#----

RUN \
    php -v \
    php -m \
    && exec composer -V

#------------------------------------------------------------------------------

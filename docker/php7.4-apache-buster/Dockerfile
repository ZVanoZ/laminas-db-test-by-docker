FROM php:7.4.25-apache-buster

ENV PHP_INI_ADD_DIR="/usr/local/etc/php/conf.d"

RUN echo 'PHP_INI_DIR is : '${PHP_INI_DIR} \
    && echo 'PHP_INI_ADD_DIR is : '${PHP_INI_ADD_DIR}

WORKDIR "/var/www"
COPY www /var/www

RUN apt update

#------------------------------------------------------------------------------
# Install common tools
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
# alien   ->
# libaio1 ->
#         -> for install *.rpm (Oracle Instant Client)
# systemtap-sdt-devel -> install OCI8 extension from PECL
#----

RUN DEBIAN_FRONTEND=noninteractive apt install -y \
    curl \
    make \
    zip \
    unzip \
    gnupg2 \
    software-properties-common \
    unixodbc-dev \
    lsof \
    wget \
    alien \
    libaio1 \
    glibc-source

#------------------------------------------------------------------------------
# Install php-composer
# Install PHP extensions
#-----

# Install PHP composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install php-extension XDebug. But not enable (see below)!
# 1. "apt-get" - Work. Dynamic version, now is  php-xdebug/oldstable 2.7.0~rc2+2.6.1+2.5.5-1 amd64
# RUN apt-get install -y php-xdebug
# 2. "docker-php-ext-install" - Fail. Not found sources (you can clone sources from github bewfore run).
#RUN docker-php-ext-install xdebug
# 3. "pecl" - Fine. Select one from many versions.
## https://pecl.php.net/package/xdebug
#RUN pecl install xdebug-2.9.8
RUN pecl install xdebug-3.1.1

# Install PHP-extension "mcrypt".
# Required "libmcrypt-dev" package for make and install.
# @see: https://pecl.php.net/package/mcrypt
RUN apt-get install -y libmcrypt-dev \
    && pecl install mcrypt-1.0.4 \
    && docker-php-ext-enable mcrypt

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql

RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Install extensions for PostgreSQL.
# Required "libpq-dev" package for make and install.
RUN DEBIAN_FRONTEND=noninteractive apt install -y libpq-dev \
    &&  docker-php-ext-install pdo pdo_pgsql pgsql

#------------------------------------------------------------------------------
# Install MSSQL client
# @see: https://docs.microsoft.com/en-us/sql/connect/odbc/download-odbc-driver-for-sql-server?view=sql-server-ver15
# @see: https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-ver15
#-----

RUN curl -s https://packages.microsoft.com/keys/microsoft.asc --output microsoft.asc
RUN apt-key add microsoft.asc

RUN curl -s https://packages.microsoft.com/config/ubuntu/20.04/mssql-server-2019.list --output /etc/apt/sources.list.d/mssql-server-2019.list
RUN curl -s https://packages.microsoft.com/config/ubuntu/20.04/prod.list --output /etc/apt/sources.list.d/mssql-server-2019.list
RUN apt-get -yq update

RUN pecl install sqlsrv
#RUN printf "; priority=20\nextension=sqlsrv.so\n" > ${PHP_INI_ADD_DIR}/sqlsrv.ini
COPY 20-sqlsrv.ini ${PHP_INI_ADD_DIR}/20-sqlsrv.ini

RUN pecl install pdo_sqlsrv
#RUN printf "; priority=30\nextension=pdo_sqlsrv.so\n" > ${PHP_INI_ADD_DIR}/pdo_sqlsrv.ini
COPY 30-pdo_sqlsrv.ini ${PHP_INI_ADD_DIR}/30-pdo_sqlsrv.ini

RUN ACCEPT_EULA=Y apt-get install -y msodbcsql17
RUN ACCEPT_EULA=Y apt-get install -y mssql-tools \
    && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc

#------------------------------------------------------------------------------
# Install Oracle client
# @TODO: install oci8 for Oracle
# @see https://www.oracle.com/database/technologies/instant-client/downloads.html
# @see https://www.oracle.com/database/technologies/instant-client/linux-x86-64-downloads.html
#-----

RUN wget -P /tmp/ https://download.oracle.com/otn_software/linux/instantclient/185000/instantclient-sdk-linux.x64-18.5.0.0.0dbru.zip
RUN wget -P /tmp/ https://download.oracle.com/otn_software/linux/instantclient/185000/instantclient-basic-linux.x64-18.5.0.0.0dbru.zip
RUN wget -P /tmp/ https://download.oracle.com/otn_software/linux/instantclient/185000/instantclient-odbc-linux.x64-18.5.0.0.0dbru.zip
RUN wget -P /tmp/ https://download.oracle.com/otn_software/linux/instantclient/185000/instantclient-sqlplus-linux.x64-18.5.0.0.0dbru.zip

RUN unzip -o /tmp/instantclient-basic-linux.x64-18.5.0.0.0dbru.zip -d /opt/oracle/
RUN unzip -o /tmp/instantclient-sdk-linux.x64-18.5.0.0.0dbru.zip -d /opt/oracle/
RUN unzip -o /tmp/instantclient-odbc-linux.x64-18.5.0.0.0dbru.zip -d /opt/oracle/
RUN unzip -o /tmp/instantclient-sqlplus-linux.x64-18.5.0.0.0dbru.zip -d /opt/oracle/

RUN ln -sfv /opt/oracle/instantclient_18_5 /opt/oracle/instantclient \
    && ln -sfv /opt/oracle/instantclient/sqlplus /usr/bin/sqlplus

#ENV NLS_LANG="AMERICAN_AMERICA.UTF8"
ENV ORACLE_HOME="/opt/oracle/instantclient"
ENV LD_LIBRARY_PATH="/opt/oracle/instantclient"
RUN echo "instantclient,/opt/oracle/instantclient/" | pecl install oci8-2.2.0
COPY 30-oci8.ini ${PHP_INI_ADD_DIR}/30-oci8.ini

RUN docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient \
    && docker-php-ext-install pdo_oci

#------------------------------------------------------------------------------
# Enamble php-extension XDebug.
# Do it finally, becouse XDebug+pecl generate warnings.
# Text of warning: "Xdebug: [Step Debug] Could not connect to debugging client..."
##----

COPY 20-xdebug.ini.sample 20-xdebug.ini
RUN ln -sfv `pwd`/20-xdebug.ini ${PHP_INI_ADD_DIR}/20-xdebug.ini

RUN a2enmod rewrite

#------------------------------------------------------------------------------
# Clean a created image
#----

RUN rm -rfv /tmp/*

#------------------------------------------------------------------------------
# Print info about result
#----

RUN exec composer -V
RUN php -v
RUN php -m
RUN ls -l ${PHP_INI_ADD_DIR}
#------------------------------------------------------------------------------

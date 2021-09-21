FROM ubuntu:20.04

WORKDIR /app

RUN apt update

#------------------------------------------------------------------------------
# Install common tools
# curl    - many tasks for dowload files
# make    - for pecl
# gnupg2 software-properties-common - for MSSQL, add "microsoft.asc"
# unixodbc-dev   - for MSSQL
#----

RUN DEBIAN_FRONTEND=noninteractive apt install -y \
      curl \
      make \
      zip \
      unzip \
      gnupg2 \
      software-properties-common \
      unixodbc-dev

#------------------------------------------------------------------------------
# Install PHP and php-composer
# php-dev php-pear -  for pecl install ...
#-----

# Install PHP and extensions

RUN DEBIAN_FRONTEND=noninteractive apt install -y \
    php-cli  php-dev php-pear \
    php-json php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath \
    php-pgsql php7.4-odbc sqlite

# Install extension XDebug
RUN apt-get install -y php-xdebug

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
RUN printf "; priority=20\nextension=sqlsrv.so\n" > /etc/php/7.4/cli/conf.d/sqlsrv.ini

RUN pecl install pdo_sqlsrv
RUN printf "; priority=30\nextension=pdo_sqlsrv.so\n" > /etc/php/7.4/cli/conf.d/pdo_sqlsrv.ini

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
RUN ln -sfv `pwd`/20-xdebug.ini /etc/php/7.4/cli/conf.d/20-xdebug.ini

#------------------------------------------------------------------------------
# Print info about result
#----

RUN \
    php -v \
    php -m \
    && exec composer -V

#------------------------------------------------------------------------------

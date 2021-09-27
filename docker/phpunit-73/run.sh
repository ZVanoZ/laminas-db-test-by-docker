#!/usr/bin/env bash
#------------------------------------------------------------------------------
set -e

cd $(dirname $(readlink -e $0))
scriptDir=`pwd`
cd ../../../laminas-db
pwd

#------------------------------------------------------------------------------
# Init
#----

if [ ! -f '20-xdebug.ini' ];then
  cp scriptDir/20-xdebug.ini.sample ./20-xdebug.ini
fi

echo 'Change option "xdebug.remote_host" in "20-xdebug.ini" to'
ifconfig docker0 | grep "inet "


#------------------------------------------------------------------------------
# Run commands
#----

# 1. Update vendor libs
docker run --rm -it --volume "$(pwd):/app" zvanoz/laminas-db-test-by-docker:73 composer update

# 2. Run unit tests
docker run --rm -it --volume "$(pwd):/app" zvanoz/laminas-db-test-by-docker:73 composer test

# 3. Run integration tests
docker run --rm -it --volume "$(pwd):/app" zvanoz/laminas-db-test-by-docker:73 composer -vvv test-integration

#------------------------------------------------------------------------------
# Some usefull commands
# 1. run
docker run --rm -it --volume "$(pwd):/app" zvanoz/laminas-db-test-by-docker:73
# It will open terminal
# 2. Type any command end run
#----
# $ dpkg --get-selections | grep php | grep mysql
# Running will give you all the modules
# $ php -m

# Running will give you a lot more detailed information on what the current configuration.
# $ php -i

# $ composer -V

#------------------------------------------------------------------------------

#!/usr/bin/env bash
#------------------------------------------------------------------------------
set -e

cd $(dirname $(readlink -e $0))
scriptDir=`pwd`
workDir=`pwd`/../../apache/www
#------------------------------------------------------------------------------
# Init
#----
echo ${workDir}/20-xdebug.ini

if [ ! -f ${workDir}/20-xdebug.ini ];then
  cp ${scriptDir}/20-xdebug.ini.sample ${workDir}/20-xdebug.ini
fi

echo 'Change option "xdebug.remote_host" in "20-xdebug.ini" to'
ifconfig docker0 | grep "inet "

#------------------------------------------------------------------------------
# Run commands
#----

#  --user 1000:1000 \
docker run --rm -it \
  --name tmp.ldbt_apache_buster \
  -p 2080:80 \
  --volume ${workDir}:/var/www \
  zvanoz/laminas-db-test-by-docker:php7.4-apache-buster

#------------------------------------------------------------------------------

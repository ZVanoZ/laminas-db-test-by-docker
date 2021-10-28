#!/bin/bash
docker run --rm -it --volume $(pwd):/var/www zvanoz/laminas-db-test-by-docker:php7.4-apache-buster composer update
#docker run --rm -it --user 1000:1000 --volume $(pwd):/var/www  zvanoz/laminas-db-test-by-docker:php7.4-apache-buster composer update

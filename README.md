# laminas-db-test-by-docker
Run unit or integration tests for "laminas-db" by docker

# How to use

```shell script
# 1. Clone sources of "laminas-db".
$ git clone https://github.com/laminas/laminas-db.git laminas-db 

# 2. Go to sources of "laminas-db"
$ cd laminas-db

# 2.1. Prepare your environment

# For  "integration tests" you need to run vagrant
# It up a container of virual box with: MySQL, PostgreSQL, MSSQL 
$ vagrant up

# For all tests copy "phpunit.xml.dist" to "phpunit.xml" in directory "laminas-db".

# For debug tests by "xdebug", you need create file "20-xdebug.ini" in directory "laminas-db".
# Examle of the file by path "laminas-db-test-by-docker/docker/phpunit-74/20-xdebug.ini.sample"

# 3. update vendors library by composer

# Check, that mapped directory is correct. Expected "laminas-db" sources.
$ docker run --rm -it --volume $(pwd):/app zvanoz/laminas-db-test-by-docker:74 ls -l

# Ubdate libraries
$ docker run --rm -it --volume $(pwd):/app zvanoz/laminas-db-test-by-docker:74 composer update

# 4. run tests

# 4.1. Run unit tests
$ docker run --rm -it --volume $(pwd):/app zvanoz/laminas-db-test-by-docker:74 composer test

# 4.2. Run integration tests
$ docker run --rm -it --volume $(pwd):/app zvanoz/laminas-db-test-by-docker:74 composer -vvv test-integration 
```

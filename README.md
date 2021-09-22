# laminas-db-test-by-docker
Run unit or integration tests for "laminas-db" by docker

* github https://github.com/ZVanoZ/laminas-db-test-by-docker
* dockerhub https://hub.docker.com/r/zvanoz/laminas-db-test-by-docker


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

# Usefull commands

````shell script
#------------------------------------------------------------------------------
# phpmyadmin
# Default options
# Server: 92.168.20.20
# Username: root
# Password: Password123
# Database: laminasdb_test
#----

# Open phpmyadmin on http://localhost:20001/
# You can ease connect to MySQL in VirtualBox
$ docker run --name myadmin -d -e PMA_ARBITRARY=1 -p 8080:80 phpmyadmin

# Open terminal for check acces to host machine from runned container
$ docker container exec -ti myadmin bash
root@...:/var/www/html# apt-get update
root@...:/var/www/html# apt install -y iputils- ping
root@...:/var/www/html# ping 92.168.20.20
#------------------------------------------------------------------------------

```
#!/usr/bin/env bash
#------------------------------------------------------------------------------
# This script runs all avalible tests in current directory scope.
# Change location to "laminas-db" sources before run the script.
#-----
echo 'current dir:'$(pwd)
ls -l
#------------------------------------------------------------------------------
#
#-----
testedVersions=(
  'zvanoz/laminas-db-test-by-docker:73'
  'zvanoz/laminas-db-test-by-docker:74'
)

for imgName in ${testedVersions[*]}; do

  printf "================================ %s ================================ \n" ${imgName}
  docker run --rm -it --volume "$(pwd):/app" ${imgName} php -v

  # 1. Update vendor libs
  docker run --rm -it --volume "$(pwd):/app" ${imgName} composer update

  # 2. Run unit tests
  docker run --rm -it --volume "$(pwd):/app" ${imgName} composer test

  # 3. Run integration tests
  docker run --rm -it --volume "$(pwd):/app" ${imgName} composer -vvv test-integration

done

#------------------------------------------------------------------------------

#!/bin/sh -e

if (php --version | grep -i HipHop > /dev/null); then
  echo "skipping application setup on HHVM"
else

    # basic application:

    composer install --dev --prefer-dist
    cd tests && codecept build && cd ../../..
fi

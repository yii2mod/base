#!/bin/sh -e

if (php --version | grep -i HipHop > /dev/null); then
  echo "skipping application init on HHVM"
else

    mysql -e 'CREATE DATABASE yii2mod_tests;';
    cd tests/codeception/bin
    php yii migrate --interactive=0
    cd ../../../../..
fi

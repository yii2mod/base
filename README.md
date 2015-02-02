Yii 2 Basic Application Template
================================

Yii 2 Basic Application Template is a skeleton Yii 2 application best for
rapidly creating small projects.

It includes all commonly used configurations that would allow you to focus on adding new
features to your application.
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/base/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/base/?branch=master) 
[![Build Status](https://scrutinizer-ci.com/g/yii2mod/base/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/base/build-status/master)
[![Code Climate](https://codeclimate.com/github/yii2mod/base/badges/gpa.svg)](https://codeclimate.com/github/yii2mod/base)


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install via Composer

* Create sources folder on the same level as httpdocs
* In sources folder run via composer:
~~~
composer global require "fxp/composer-asset-plugin:1.0.0"
composer create-project --prefer-dist --stability=dev yii2mod/base .
~~~
If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).
* Make a symlink for web folder to httpdocs

CONFIGURATION
-------------
Check and edit `*.local.php` files in the `config/` directory to customize your application.
After check configs, execute migrations by command `php yii migrate`

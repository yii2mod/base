Yii 2 Basic Application Template
================================

Yii 2 Basic Application Template is a skeleton Yii 2 application best for
rapidly creating small projects.

It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yii2mod/base/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yii2mod/base/?branch=master) 
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

## Installing using Composer

If you do not have [Composer](http://getcomposer.org/), follow the instructions in the
[Installing Yii](https://github.com/yiisoft/yii2/blob/master/docs/guide/start-installation.md#installing-via-composer) section of the definitive guide to install it.

With Composer installed, you can then install the application using the following commands:

    composer global require "fxp/composer-asset-plugin:~1.1.1"
    composer create-project --prefer-dist --stability=dev yii2mod/base application

The first command installs the [composer asset plugin](https://github.com/francoispluchino/composer-asset-plugin/)
which allows managing bower and npm package dependencies through Composer. You only need to run this command
once for all. The second command installs the advanced application in a directory named `application`.
You can choose a different directory name if you want.

CONFIGURATION
-------------
After you install the application, you have to conduct the following steps to initialize
the installed application. You only need to do these once for all.

1. Create a new database and adjust the `components['db']` configuration in `config/main-local.php` accordingly.

2. Apply migrations with console command `yii migrate`.

3. Set document root of your web server to `/path/to/application/web/` folder.


####To login into the application, use the following credentials:
- email - `admin@mail.com`
- password - `123123`


Special thanks to
------------
[![PhpStorm](https://www.jetbrains.com/phpstorm/documentation/docs/logo_phpstorm.png)](https://www.jetbrains.com/phpstorm/)

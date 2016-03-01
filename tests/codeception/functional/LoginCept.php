<?php
/* @var $scenario Codeception\Scenario */

use codeception\_pages\LoginPage;

$I = new FunctionalTester($scenario);
$I->wantTo('ensure login page works');
$loginPage = LoginPage::openBy($I);
$I->amGoingTo('submit login form with no data');
$loginPage->login('', '');
$I->expectTo('see validations errors');
$I->see('Email cannot be blank.', '.help-block');
$I->see('Password cannot be blank.', '.help-block');
$I->amGoingTo('try to login with wrong credentials');
$I->expectTo('see validations errors');
$loginPage->login('admin', 'wrong');
$I->expectTo('see validations errors');
$I->see('Incorrect username or password.', '.help-block');
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('admin@mail.com', '123123');
$I->expectTo('see that user is logged');
$I->see('Logout (admin)', 'form button[type=submit]');
$I->dontSeeLink('Login');
$I->dontSeeLink('Signup');
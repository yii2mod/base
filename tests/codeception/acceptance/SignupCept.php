<?php
use codeception\_pages\SignupPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that signup works');
$signupPage = SignupPage::openBy($I);
$I->see('Signup', 'h1');
$I->see('Please fill out the following fields to signup:');
$I->amGoingTo('submit signup form with no data');
$signupPage->submit([]);
$I->expectTo('see validation errors');
$I->see('Username cannot be blank.', '.help-block');
$I->see('Email cannot be blank.', '.help-block');
$I->see('Password cannot be blank.', '.help-block');
$I->amGoingTo('submit signup form with not correct email');
$signupPage->submit([
    'username' => 'tester',
    'email' => 'tester.email',
    'password' => 'tester_password',
]);
$I->expectTo('see that email address is wrong');
$I->dontSee('Username cannot be blank.', '.help-block');
$I->dontSee('Password cannot be blank.', '.help-block');
$I->see('Email is not a valid email address.', '.help-block');
$I->amGoingTo('submit signup form with correct email');
$signupPage->submit([
    'username' => 'tester',
    'email' => 'tester.email@example.com',
    'password' => 'tester_password',
]);
$I->expectTo('see that user logged in');
$I->see('Logout (tester)', 'form button[type=submit]');

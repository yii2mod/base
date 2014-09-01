<?php
use codeception\_pages\SignupPage;

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that signup works');


$signupPage = SignupPage::openBy($I);

$I->see('New Customer Signup', 'h1');

$I->amGoingTo('try to sign up with empty fields');
$signupPage->submit([]);
$I->wait(1);
$I->expectTo('see validations errors');
$I->see('Customer Name cannot be blank.');
$I->see('Confirm Password cannot be blank.');
$I->see('Email Address cannot be blank.');

$I->amGoingTo('try to signup with existing email');

$signupPage->submit([
    "username" => "Dmitry",
    "license" => "12344",
    "password" => "123123",
    "confirmPassword" => "123123",
    "addressName" => "heroiv",
    "address1" => "sta",
    "address2" => "ta",
    "address1" => "sta123",
    "address2" => "ta345",
    "city" => "Kharkiv",
    "stateId" => "District of Columbia",
    "zip" => "456",
    "phone" => "123123123",
    "fax" => "123123123",
    "firstName" => "qweqwr",
    "lastName" => "rtyrty",
    "title" => "345456",
    "phone1" => "123123123",
    "phone1Ext" => "33",
    "phone1Location" => "Home",
    "phone1Location" => "2",
    "phone2" => "wewert",
    "phone2Ext" => "546",
    "phone2Location" => "Home",
    "phone2Location" => "2",
    "phone2" => "456456456",
    "email" => "disemx@gmail.com",
    "hours" => "233",
]);


$I->wait(1);


$I->expectTo('see user info');
$I->see('Logout');








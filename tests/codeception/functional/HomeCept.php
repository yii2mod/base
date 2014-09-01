<?php

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('Featured Products');
$I->see('About WEBCO Dental Supplies & Equipment');
$I->seeLink('About Us');
$I->click('About Us');
$I->see('About Us');

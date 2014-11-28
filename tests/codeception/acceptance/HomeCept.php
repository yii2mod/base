<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('Featured Products');
$I->see('Congratulations');
$I->seeLink('About Us');
$I->click('About');
$I->see('About Us');

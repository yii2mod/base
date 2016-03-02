<?php

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('Yii2 Basic Template');
$I->seeLink('About');
$I->click('About');
$I->see('About us content');

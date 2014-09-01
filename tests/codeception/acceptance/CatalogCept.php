<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure catalog works fine');
$I->amOnPage('/product/search');
$I->see('Products');
$I->seeLink('Mfg');
$I->click('Mfg');
$I->see('Products');

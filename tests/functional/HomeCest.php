<?php

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->seeLink('About Us');
        $I->seeLink('Contact');
    }
}
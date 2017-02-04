<?php

namespace app\tests\functional;

use app\tests\fixtures\CmsFixture;
use FunctionalTester;

class AboutCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'cms' => [
                'class' => CmsFixture::class,
            ],
        ]);
    }

    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute('/about-us');
        $I->see('About us', 'h1');
    }
}

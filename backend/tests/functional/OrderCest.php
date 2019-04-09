<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\order\OrderFixture;
use common\fixtures\user\ProfileFixture;
use common\fixtures\user\UserFixture;

class OrderCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            OrderFixture::class,
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function index(FunctionalTester $I)
    {
        $I->amOnPage('/auth/sign-in');
        $I->fillField(['id' => 'signinform-username'], 'admin');
        $I->fillField(['id' => 'signinform-password'], 'password_0');
        $I->click('login-button');

        $I->amOnPage('/order');
        $I->see('driverov driver');
        $I->see('userov user');
    }

}

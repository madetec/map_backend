<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\OrderFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;

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
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir('users_data.php')
            ],
            'profile' => [
                'class' => ProfileFixture::class,
                'dataFile' => codecept_data_dir('profiles_data.php')
            ],
            'order' => [
                'class' => OrderFixture::class,
                'dataFile' => codecept_data_dir('orders_data.php')
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function index(FunctionalTester $I)
    {
        $I->amOnPage('/auth/sign-in');
        $I->fillField(['id' => 'signinform-username'], 'userAdmin');
        $I->fillField(['id' => 'signinform-password'], 'password_0');
        $I->click('login-button');

        $I->amOnPage('/order');
        $I->see('driverov driver');
        $I->see('userov user');
    }

}

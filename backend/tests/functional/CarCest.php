<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\user\ProfileFixture;

class CarCest
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
            ProfileFixture::class,
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function createCar(FunctionalTester $I)
    {
        $I->amOnPage('/auth/sign-in');
        $I->fillField(['id' => 'signinform-username'], 'admin');
        $I->fillField(['id' => 'signinform-password'], 'password_0');
        $I->click('login-button');

        $I->amOnPage('/car/create');
        $I->fillField(['id' => 'carform-model'], 'daewoo nexia');
        $I->selectOption('select[id=carform-color_id]', ['value' => '221']);
        $I->fillField(['id' => 'carform-number'], '01 222 ABC');
        $I->selectOption('select[id=carform-user_id]', ['value' => '3']);
        $I->click('[type=submit]');

        $I->see('driverov driver driverovich');
        $I->see('daewoo nexia');
        $I->see('Чёрный, Чёрный');
    }

}

<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\user\ProfileFixture;
use common\fixtures\user\UserFixture;

/**
 * Class SignInCest
 */
class SignInCest
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
    public function signInUser(FunctionalTester $I)
    {
        $I->amOnPage('/auth/sign-in');
        $I->fillField(['id' => 'signinform-username'], 'admin');
        $I->fillField(['id' => 'signinform-password'], 'password_0');
        $I->click('login-button');

//        $I->see('Sign out', 'a[data-method="post"]');
    }


    public function SignInIsAccessDenied(FunctionalTester $I)
    {
        $I->amOnPage('/auth/sign-in');
        $I->fillField(['id' => 'signinform-username'], 'driver');
        $I->fillField(['id' => 'signinform-password'], 'password_0');
        $I->click('login-button');

        $I->see('Access is denied!');
    }
}

<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;

/**
 * Class SignInCest
 */
class UserCest
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
                'dataFile' => codecept_data_dir('login_users.php')
            ],
            'profile' => [
                'class' => ProfileFixture::class,
                'dataFile' => codecept_data_dir('login_profiles.php')
            ]
        ];
    }

    /**
     * @param FunctionalTester $I
     */
    public function createUser(FunctionalTester $I)
    {
        $I->amOnPage('/auth/sign-in');
        $I->fillField(['id' => 'signinform-username'], 'userAdmin');
        $I->fillField(['id' => 'signinform-password'], 'password_0');
        $I->click('login-button');

        $I->amOnPage('/user/create');
        $I->fillField(['id' => 'profileform-name'], 'test');
        $I->fillField(['id' => 'profileform-last_name'], 'last_test');
        $I->fillField(['id' => 'profileform-father_name'], 'father_test');
        $I->fillField(['id' => 'profileform-position'], 'position_test');
        $I->fillField(['id' => 'phoneform-number'], '974457018');
        $I->fillField(['id' => 'addressform-name'], 'address_test');
        $I->fillField(['id' => 'userform-username'], 'username_test');
        $I->fillField(['id' => 'userform-password'], 'password_test');
        $I->selectOption('select[id=userform-role]', ['value' => 'user']);
        $I->click('[type=submit]');

        $I->see('username_test');
        $I->see('974457018');
        $I->see('address_test');

    }

}

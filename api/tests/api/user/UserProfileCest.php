<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;
use api\tests\ApiTester;
use common\fixtures\OauthAccessTokenFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;

class UserProfileCest
{
    public function _fixtures(): array
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
            'tokens' => [
                'class' => OauthAccessTokenFixture::class,
                'dataFile' => codecept_data_dir('tokens.php')
            ]
        ];
    }

    public function getProfile(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/profile');
        $I->canSeeResponseContainsJson([
            'username' => 'erau',
        ]);
    }

    public function getRole(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/role');
        $I->canSeeResponseContainsJson([
            'role' => 'user',
        ]);
    }
    public function getRoles(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/roles');
        $I->canSeeResponseContainsJson([
            'role' => 'user',
        ]);
    }

    public function addAddress(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendPATCH('/user/profile/address', [
            'name' => 'Tashkent',
            'lat' => 534.23232,
            'lng' => 764.534,
        ]);
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/profile');
        $I->seeResponseCodeIs(200);
    }
}
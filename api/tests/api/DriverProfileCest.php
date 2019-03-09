<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api;

use api\tests\ApiTester;
use common\fixtures\OauthAccessTokenFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;

class DriverProfileCest
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

    public function busy(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/status/busy');
        $I->canSeeResponseCodeIs(200);
    }

    public function active(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/status/busy');
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/status/active');
        $I->canSeeResponseCodeIs(200);
    }

    public function busyError(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/status/busy');
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/status/busy');
        $I->canSeeResponseCodeIs(400);
    }

    public function activeError(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/status/active');
        $I->canSeeResponseCodeIs(400);
    }



}
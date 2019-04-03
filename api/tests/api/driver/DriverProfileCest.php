<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\driver;

use api\tests\ApiTester;
use common\fixtures\Oauth20\OauthAccessTokenFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;

class DriverProfileCest
{
    public function _fixtures(): array
    {
        return [
            OauthAccessTokenFixture::class,
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
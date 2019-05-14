<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;

use api\tests\ApiTester;
use common\fixtures\car\CarFixture;
use common\fixtures\Oauth20\OauthAccessTokenFixture;
use common\fixtures\order\OrderFixture;
use common\fixtures\user\DeviceFixture;

class DriverOrderCest
{
    public function _fixtures(): array
    {
        return [
            OauthAccessTokenFixture::class,
            OrderFixture::class,
            CarFixture::class,
            DeviceFixture::class
        ];
    }

    public function completed(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/order/2/completed');
        $I->canSeeResponseCodeIs(200);
    }

    public function started(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/order/2/started');
        $I->canSeeResponseCodeIs(200);
    }

    public function isWaiting(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/order/2/waiting');
        $I->canSeeResponseCodeIs(200);
    }

    public function take(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/order/1/take');
        $I->canSeeResponseCodeIs(200);
    }

    public function cancel(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/order/2/cancel');
        $I->canSeeResponseCodeIs(200);
    }
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;

use api\tests\ApiTester;
use common\fixtures\Oauth20\OauthAccessTokenFixture;
use common\fixtures\order\OrderFixture;

class DriverOrderCest
{
    public function _fixtures(): array
    {
        return [
            OauthAccessTokenFixture::class,
            OrderFixture::class,
        ];
    }

    public function completed(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-driver');
        $I->sendPATCH('/driver/order/2/completed');
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
        $I->sendPATCH('/driver/order/1/cancel');
        $I->canSeeResponseCodeIs(200);
    }
}
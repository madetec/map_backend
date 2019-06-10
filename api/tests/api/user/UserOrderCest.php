<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;

use api\tests\ApiTester;
use common\fixtures\notification\NotificationAssignmentsFixture;
use common\fixtures\Oauth20\OauthAccessTokenFixture;
use common\fixtures\order\OrderFixture;
use common\fixtures\user\DeviceFixture;
use yii\helpers\VarDumper;

class UserOrderCest
{
    public function _fixtures(): array
    {
        return [
            OauthAccessTokenFixture::class,
            OrderFixture::class,
            NotificationAssignmentsFixture::class,
            DeviceFixture::class
        ];
    }

    public function getActive(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendGET('/user/order/active');
        $I->seeResponseCodeIs(200);
    }

    public function create(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPATCH('/user/order/1/cancel');
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPATCH('/user/order/2/cancel');
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPATCH('/user/order/4/cancel');
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPATCH('/user/order/5/cancel');

        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPOST('/user/order', [
            'from_lat' => 323.23,
            'from_lng' => 321.23,
            'from_address' => 'uzbekistan',
        ]);

        $I->canSeeResponseContainsJson([
            'from' => [
                'lat' => 323.23
            ],
        ]);

    }

    public function getAllOrders(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendGET('/user/order');
        $I->canSeeResponseContainsJson([
            [
                'from' => [
                    'lat' => 41.279174
                ],
            ]
        ]);
    }

    public function cancel(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPATCH('/user/order/2/cancel');
        VarDumper::dump($I->grabResponse());
        $I->canSeeResponseCodeIs(200);
    }
}

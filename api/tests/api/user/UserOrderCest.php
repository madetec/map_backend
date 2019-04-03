<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;

use api\tests\ApiTester;
use common\fixtures\Oauth20\OauthAccessTokenFixture;
use common\fixtures\order\OrderFixture;
use yii\helpers\VarDumper;

class UserOrderCest
{
    public function _fixtures(): array
    {
        return [
            OauthAccessTokenFixture::class,
            OrderFixture::class,
        ];
    }

    public function create(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendPOST('/user/order', [
            'from_lat' => 323.23,
            'from_lng' => 321.23,
            'from_address' => 'fdsfds fdfsd',
        ]);
        $I->canSeeResponseContainsJson([
            'from' => [
                'lat' => 323.23
            ],
        ]);
    }

    public function getAllOrders(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/order');
        $I->canSeeResponseContainsJson([
            [
                'from' => [
                    'lat' => 123.124
                ],
            ]

        ]);
    }

    public function cancel(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendPATCH('/user/order/1/cancel');
        $I->canSeeResponseCodeIs(200);
    }

}
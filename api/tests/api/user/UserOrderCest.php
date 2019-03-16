<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;

use api\tests\ApiTester;
use common\fixtures\OauthAccessTokenFixture;
use common\fixtures\OrderFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use yii\helpers\VarDumper;

class UserOrderCest
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
            ],
            'orders' => [
                'class' => OrderFixture::class,
                'dataFile' => codecept_data_dir('orders_data.php')
            ]
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
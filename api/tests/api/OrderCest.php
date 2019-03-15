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

class OrderCest
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

    public function orders(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/orders');
        $I->canSeeResponseContainsJson([
            'from' => [
                'lat' => 323.23
            ],
        ]);
    }

    public function create(ApiTester $I): void
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


}
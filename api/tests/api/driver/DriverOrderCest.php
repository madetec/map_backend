<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api\user;

use api\tests\ApiTester;
use common\fixtures\Oauth20\OauthAccessTokenFixture;
use common\fixtures\OrderFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use yii\helpers\VarDumper;

class DriverOrderCest
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
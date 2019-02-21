<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api;
use api\tests\ApiTester;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use yii\helpers\VarDumper;

class ProfileCest
{
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir('login_data.php')
            ],
            'profile' => [
                'class' => ProfileFixture::class,
                'dataFile' => codecept_data_dir('login_profiles.php')
            ]
        ];
    }
    public function success(ApiTester $I): void
    {
        $I->sendPOST('/oauth2/token', [
            'grant_type' => 'user_credentials',
            'client_id' => 'ale ale',
            'client_secret' => 'bla bla',
        ]);

        VarDumper::dump($I->grabResponse());

    }
}
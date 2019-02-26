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
use Composer\Installers\FuelphpInstaller;
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
            ],
            'tokens' => [
                'class' => OauthAccessTokenFixture::class,
                'dataFile' => codecept_data_dir('tokens.php')
            ]
        ];
    }

    public function getProfile(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/profile');
        $I->canSeeResponseContainsJson([
            'username' => 'erau',
        ]);
    }

    public function getRole(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/role');
        $I->canSeeResponseContainsJson([
            'role' => 'user',
        ]);
    }
    public function getRoles(ApiTester $I): void
    {
        $I->amBearerAuthenticated('token-correct');
        $I->sendGET('/user/roles');
        $I->canSeeResponseContainsJson([
            'role' => 'user',
        ]);
    }
}
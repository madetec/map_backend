<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\tests\api;
use api\tests\ApiTester;
use common\fixtures\Oauth20\OauthRefreshTokenFixture;
use common\fixtures\ProfileFixture;
use common\fixtures\UserFixture;
use yii\helpers\VarDumper;

class AuthCest
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
            'refresh-tokens' => [
                'class' => OauthRefreshTokenFixture::class,
                'dataFile' => codecept_data_dir('refresh_tokens.php')
            ]
        ];
    }

    public function refreshToken(ApiTester $I): void
    {
        $I->sendPOST('/oauth2/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => 'refresh_token',
            'client_id' => 'testclient',
            'client_secret' => 'testpass'
        ]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'expires_in' => 86400,
            'token_type' => 'Bearer',
            'scope' => null,
        ]);
    }
    public function success(ApiTester $I): void
    {
        $I->sendPOST('/oauth2/token', [
            'grant_type' => 'password',
            'username' => 'erau',
            'password' => 'password_0',
            'client_id' => 'testclient',
            'client_secret' => 'testpass'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'expires_in' => 86400,
            'token_type' => 'Bearer',
            'scope' => null,
        ]);

        $I->seeResponseJsonMatchesJsonPath('$.access_token');
        $I->seeResponseJsonMatchesJsonPath('$.refresh_token');
    }
    public function error(ApiTester $I): void
    {
        $I->sendPOST('/oauth2/token', [
            'grant_type' => 'password',
            'username' => 'erau',
            'password' => 'asf344',
            'client_id' => 'testclient',
            'client_secret' => 'testpass'
        ]);
        $I->seeResponseCodeIs(401);
        $I->seeResponseIsJson();
    }
}
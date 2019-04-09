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

class DeviceCest
{
    public function _fixtures(): array
    {
        return [
            OauthAccessTokenFixture::class
        ];
    }

    public function addSuccess(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPOST('/device/add',[
            'uid' => 'UID',
            'firebase_token' => 'Firebase token',
            'name' => 'android',
        ]);
        $I->canSeeResponseCodeIs(200);
    }

    public function addError(ApiTester $I)
    {
        $I->amBearerAuthenticated('token-correct-user');
        $I->sendPOST('/device/add');
        $I->canSeeResponseCodeIs(422);
    }

}
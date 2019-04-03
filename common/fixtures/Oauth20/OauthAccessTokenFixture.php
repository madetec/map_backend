<?php
namespace common\fixtures\Oauth20;

use common\fixtures\user\ProfileFixture;
use filsh\yii2\oauth2server\models\OauthAccessTokens;
use yii\test\ActiveFixture;

class OauthAccessTokenFixture extends ActiveFixture
{
    public $modelClass = OauthAccessTokens::class;
    public $dataFile = __DIR__ . "/_data/access_tokens.php";
    public $depends = [ProfileFixture::class];
}
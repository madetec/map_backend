<?php
namespace common\fixtures\Oauth20;

use filsh\yii2\oauth2server\models\OauthRefreshTokens;
use yii\test\ActiveFixture;

class OauthRefreshTokenFixture extends ActiveFixture
{
    public $modelClass = OauthRefreshTokens::class;
    public $dataFile = __DIR__ . "/_data/refresh_tokens.php";
}
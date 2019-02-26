<?php
namespace common\fixtures;

use filsh\yii2\oauth2server\models\OauthAccessTokens;
use yii\test\ActiveFixture;

class OauthAccessTokenFixture extends ActiveFixture
{
    public $modelClass = OauthAccessTokens::class;
}
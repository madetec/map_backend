<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace common\fixtures\Oauth20;


use filsh\yii2\oauth2server\models\OauthClients;

class OauthClientFixture
{
    public $modelClass = OauthClients::class;
    public $dataFile = __DIR__ . "/_data/clients.php";
}
<?php

namespace common\fixtures\user;

use uztelecom\entities\user\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = __DIR__ . "/_data/users_data.php";
}
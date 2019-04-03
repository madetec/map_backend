<?php

namespace common\fixtures\user;

use uztelecom\entities\user\Profile;
use yii\test\ActiveFixture;

class ProfileFixture extends ActiveFixture
{
    public $modelClass = Profile::class;
    public $dataFile = __DIR__ . "/_data/profiles_data.php";
    public $depends = [UserFixture::class];
}
<?php
namespace common\fixtures;

use uztelecom\entities\user\Profile;
use yii\test\ActiveFixture;

class ProfileFixture extends ActiveFixture
{
    public $modelClass = Profile::class;
}
<?php


namespace common\fixtures\user;


use uztelecom\entities\user\Device;
use yii\test\ActiveFixture;

class DeviceFixture extends ActiveFixture
{
    public $modelClass = Device::class;
    public $dataFile = __DIR__ . "/_data/devices_data.php";
    public $depends = [UserFixture::class, ProfileFixture::class];
}
<?php

namespace common\fixtures\notification;

use common\fixtures\order\OrderFixture;
use common\fixtures\user\ProfileFixture;
use common\fixtures\user\UserFixture;
use uztelecom\entities\notification\Notification;
use yii\test\ActiveFixture;

class NotificationFixture extends ActiveFixture
{
    public $modelClass = Notification::class;
    public $dataFile = __DIR__ . "/_data/notification_data.php";
    public $depends = [
        UserFixture::class,
        ProfileFixture::class,
        OrderFixture::class
    ];
}
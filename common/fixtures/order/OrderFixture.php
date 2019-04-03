<?php

namespace common\fixtures\order;

use common\fixtures\user\ProfileFixture;
use common\fixtures\user\UserFixture;
use uztelecom\entities\orders\Order;
use yii\test\ActiveFixture;

class OrderFixture extends ActiveFixture
{
    public $modelClass = Order::class;
    public $dataFile = __DIR__ . "/_data/orders_data.php";
    public $depends = [UserFixture::class, ProfileFixture::class];
}
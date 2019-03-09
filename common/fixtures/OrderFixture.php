<?php
namespace common\fixtures;

use uztelecom\entities\orders\Order;
use yii\test\ActiveFixture;

class OrderFixture extends ActiveFixture
{
    public $modelClass = Order::class;
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace common\fixtures\car;


use common\fixtures\user\ProfileFixture;
use uztelecom\entities\cars\Car;
use yii\test\ActiveFixture;

class CarFixture extends ActiveFixture
{
    public $modelClass = Car::class;
    public $dataFile = __DIR__ . "/_data/cars_data.php";
    public $depends = [ProfileFixture::class];
}
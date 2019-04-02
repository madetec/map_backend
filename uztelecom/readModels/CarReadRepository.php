<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;

use uztelecom\entities\cars\Car;
use yii\base\Component;

/**
 * @property $totalCount
 */
class CarReadRepository extends Component
{
    public function getTotalCount()
    {
        return Car::find()->count();
    }

    public function find($id): ?Car
    {
        return Car::findOne($id);
    }
}
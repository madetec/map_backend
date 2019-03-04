<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;

use uztelecom\entities\cars\Car;

class CarReadRepository
{
    public function find($id): ?Car
    {
        return Car::findOne($id);
    }
}
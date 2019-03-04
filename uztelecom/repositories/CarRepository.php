<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\repositories;


use uztelecom\entities\cars\Car;
use uztelecom\exceptions\NotFoundException;

class CarRepository
{
    /**
     * @param int $id
     * @return Car
     * @throws NotFoundException
     */
    public function find(int $id): Car
    {
        if (!$car = Car::findOne($id)) {
            throw new NotFoundException('Car not found.');
        }

        return $car;
    }

    /**
     * @param Car $car
     * @throws \DomainException
     */
    public function save(Car $car): void
    {
        if (!$car->save()) {
            throw new \DomainException('Car save error');
        }
    }

    /**
     * @param Car $car
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Car $car): void
    {
        if (!$car->delete()) {
            throw new \DomainException('Car remove error');
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 22:17
 */

namespace uztelecom\services;

use uztelecom\entities\cars\Car;
use uztelecom\forms\cars\CarForm;
use uztelecom\repositories\CarRepository;
use uztelecom\repositories\UserRepository;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CarManageService
 * @package uztelecom\services
 * @property  CarRepository $cars
 * @property  UserRepository users
 */
class CarManageService
{
    private $users;
    private $cars;

    public function __construct(CarRepository $carRepository, UserRepository $userRepository)
    {
        $this->cars = $carRepository;
        $this->users = $userRepository;
    }

    /**
     * @param CarForm $form
     * @return Car
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function create(CarForm $form): Car
    {
        $user = $this->users->find($form->user_id);
        $car = Car::create(
            $form->model,
            $form->color_id,
            $form->number,
            $user->id
        );
        $this->cars->save($car);
        return $car;
    }

    /**
     * @param $id
     * @param CarForm $form
     * @return Car
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function edit(int $id, CarForm $form)
    {
        $user = $this->users->find($form->user_id);
        $car = $this->cars->find($id);
        $car->edit(
            $form->model,
            $form->color_id,
            $form->number,
            $user->id
        );
        $this->cars->save($car);
        return $car;
    }
}
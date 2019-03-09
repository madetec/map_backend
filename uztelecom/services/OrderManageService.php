<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 22:17
 */

namespace uztelecom\services;

use uztelecom\entities\orders\Order;
use uztelecom\forms\orders\OrderForm;
use uztelecom\repositories\CarRepository;
use uztelecom\repositories\OrderRepository;
use uztelecom\repositories\UserRepository;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CarManageService
 * @package uztelecom\services
 * @property  CarRepository $cars
 * @property  UserRepository $users
 * @property  OrderRepository $orders
 */
class OrderManageService
{
    private $users;
    private $cars;
    private $orders;

    public function __construct(
        CarRepository $carRepository,
        UserRepository $userRepository,
        OrderRepository $orderRepository
    )
    {
        $this->cars = $carRepository;
        $this->users = $userRepository;
        $this->orders = $orderRepository;
    }

    /**
     * @param int $user_id
     * @param OrderForm $form
     * @return Order
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function create(int $user_id, OrderForm $form): Order
    {
        $user = $this->users->find($user_id);
        $order = Order::create(
            $user->id,
            $form->from_lat,
            $form->from_lng,
            $form->from_address,
            $form->to_lat,
            $form->to_lng,
            $form->to_address
        );
        $this->orders->save($order);
        return $order;
    }

    /**
     * @param int $driver_id
     * @param int $order_id
     * @return Order
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function takeOrder(int $driver_id, int $order_id): Order
    {
        $driver = $this->users->find($driver_id);
        $order = $this->orders->find($order_id);
        $order->takeOrder($driver->id);
        $this->orders->save($order);
        return $order;
    }

    /**
     * @param int $order_id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function completed(int $order_id): void
    {
        $order = $this->orders->find($order_id);
        $order->completed();
        $this->orders->save($order);
    }

    /**
     * @param int $order_id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function canceled(int $order_id): void
    {
        $order = $this->orders->find($order_id);
        $order->canceled();
        $this->orders->save($order);
    }
}
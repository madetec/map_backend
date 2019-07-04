<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 22:17
 */

namespace uztelecom\services;

use uztelecom\entities\notification\Notification;
use uztelecom\entities\orders\Order;
use uztelecom\entities\user\User;
use uztelecom\events\notification\NotificationEvent;
use uztelecom\exceptions\NotFoundException;
use uztelecom\forms\orders\OrderForm;
use uztelecom\repositories\CarRepository;
use uztelecom\repositories\OrderRepository;
use uztelecom\repositories\UserRepository;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class OrderManageService
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
     * @param int $driver_id
     * @param int $order_id
     * @return Order
     * @throws NotFoundException
     * @throws \DomainException
     */
    public function isWaiting(int $driver_id, int $order_id)
    {
        $driver = $this->users->findRoleDriver($driver_id);
        $this->thisDriverHasCar($driver);
        $order = $this->orders->findActive($order_id);
        $order->driverIsWaiting();
        $this->orders->save($order);

        $notificationEvent = NotificationEvent::create(
            $driver->id,
            $order->created_by,
            Notification::TYPE_DRIVER_IS_WAITING,
            $order->id
        );

        $order->trigger(Order::EVENT_DRIVER_IS_WAITING, $notificationEvent);

        return $order;
    }

    /**
     * @param int $driver_id
     * @param int $order_id
     * @return Order
     * @throws NotFoundException
     * @throws \DomainException
     */
    public function started(int $driver_id, int $order_id)
    {
        $driver = $this->users->findRoleDriver($driver_id);
        $this->thisDriverHasCar($driver);
        $order = $this->orders->findActive($order_id);
        $order->driverStartedTheRide();
        $this->orders->save($order);

        $notificationEvent = NotificationEvent::create(
            $driver->id,
            $order->created_by,
            Notification::TYPE_DRIVER_STARTED_THE_RIDE,
            $order->id
        );

        $order->trigger(Order::EVENT_DRIVER_STARTED_THE_RIDE, $notificationEvent);

        return $order;
    }

    /**
     * @param int $user_id
     * @param OrderForm $form
     * @return Order
     * @throws NotFoundException
     * @throws \DomainException
     */
    public function create(int $user_id, OrderForm $form): Order
    {
        $user = $this->users->findRoleUser($user_id);
        $this->haveActiveOrder($user->id);
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

        $notificationEvent = NotificationEvent::create(
            $user->id,
            null,
            Notification::TYPE_NEW_ORDER,
            $order->id
        );

        $order->trigger(Order::EVENT_NEW_ORDER, $notificationEvent);

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
        $driver = $this->users->findRoleDriver($driver_id);
        $this->thisDriverHasCar($driver);
        $order = $this->orders->findActive($order_id);
        $order->takeOrder($driver->id);
        $this->orders->save($order);

        $notificationEvent = NotificationEvent::create(
            $driver->id,
            $order->created_by,
            Notification::TYPE_TAKE_ORDER,
            $order->id
        );

        $order->trigger(Order::EVENT_TAKE_ORDER, $notificationEvent);

        return $order;
    }

    /**
     * @param int $order_id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function completed(int $order_id): void
    {
        $order = $this->orders->findStarted($order_id);
        $order->completed();
        $this->orders->save($order);
        $notificationEvent = NotificationEvent::create(
            $order->driver->id,
            $order->created_by,
            Notification::TYPE_COMPLETED,
            $order->id
        );
        $order->trigger(Order::EVENT_COMPLETED, $notificationEvent);
    }

    /**
     * @param int $order_id
     * @throws NotFoundException
     * @throws \DomainException
     */
    public function canceled(int $order_id): void
    {
        $order = $this->orders->findActive($order_id);
        $order->canceled();
        $this->orders->save($order);
        if ($order->driver) {
            if ($order->driver->isBusy()) {
                $order->driver->active();
            }
            if ($order->driver->id === \Yii::$app->user->getId()) {
                $fromId = $order->driver->id;
                $toId = $order->created_by;
            } else {
                $fromId = $order->created_by;
                $toId = $order->driver->id;
            }
            $notificationEvent = NotificationEvent::create(
                $fromId,
                $toId,
                Notification::TYPE_CANCEL_ORDER,
                $order->id
            );
            $order->trigger(Order::EVENT_CANCEL_ORDER, $notificationEvent);
        }
    }

    /**
     * @param User $driver
     * @throws NotFoundException
     */
    protected function thisDriverHasCar(User $driver): void
    {
        if (!$driver->car) throw new  NotFoundException('This driver has no car');
    }

    /**
     * @param $user_id
     * @throws \DomainException
     */
    protected function haveActiveOrder($user_id)
    {
        if ($this->orders->getActiveOrder($user_id)) {
            throw new \DomainException('You already have an active order.');
        }
    }
}

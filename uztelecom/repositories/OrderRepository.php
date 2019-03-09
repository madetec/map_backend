<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\repositories;


use uztelecom\entities\orders\Order;
use uztelecom\exceptions\NotFoundException;

class OrderRepository
{
    /**
     * @param int $id
     * @return Order
     * @throws NotFoundException
     */
    public function find(int $id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new NotFoundException('Order not found.');
        }
        return $order;
    }

    /**
     * @param Order $order
     * @throws \DomainException
     */
    public function save(Order $order): void
    {
        if (!$order->save()) {
            throw new \DomainException('Order save error');
        }
    }

    /**
     * @param Order $order
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(Order $order): void
    {
        if (!$order->delete()) {
            throw new \DomainException('Order remove error');
        }
    }
}
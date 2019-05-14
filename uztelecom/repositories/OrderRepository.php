<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\repositories;


use uztelecom\entities\orders\Order;
use uztelecom\exceptions\NotFoundException;
use yii\db\ActiveRecord;

class OrderRepository
{
    /**
     * @param $user_id
     * @return Order|null|ActiveRecord
     */
    public function getActiveOrder($user_id): ?Order
    {
        return Order::find()
            ->where(['created_by' => $user_id])
            ->andWhere(['!=', 'status', Order::STATUS_CANCELED])
            ->one();
    }

    /**
     * @param int $id
     * @return Order|ActiveRecord
     * @throws NotFoundException
     */
    public function findBusy(int $id): Order
    {
        if (!$order = Order::find()->where(['id' => $id])->busy()->one()) {
            throw new NotFoundException('Order not found.');
        }
        return $order;
    }

    /**
     * @param int $id
     * @return Order
     * @throws NotFoundException
     */
    public function findActive(int $id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new NotFoundException('Order not found.');
        }
        return $order;
    }

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
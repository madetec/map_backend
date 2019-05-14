<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities\orders\queries;


use uztelecom\entities\orders\Order;
use yii\db\ActiveQuery;

class OrderQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Order::STATUS_ACTIVE,
        ]);
    }

    public function busy($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Order::STATUS_DRIVER_ON_THE_ROAD,
        ]);
    }

    public function canceled($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Order::STATUS_CANCELED,
        ]);
    }

    public function completed($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Order::STATUS_COMPLETED,
        ]);
    }

    public function wait($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Order::STATUS_DRIVER_IS_WAITING,
        ]);
    }
}
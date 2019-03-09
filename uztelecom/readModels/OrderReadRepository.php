<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;
use uztelecom\entities\orders\Order;

class OrderReadRepository
{
    public function find($id): ?Order
    {
        return Order::findOne($id);
    }
}
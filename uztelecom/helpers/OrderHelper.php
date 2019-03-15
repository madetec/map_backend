<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use uztelecom\entities\orders\Order;

class OrderHelper
{
    public static function serializeStatus($status)
    {
        $name = null;
        $code = $status;
        switch ($status) {
            case Order::STATUS_ACTIVE:
                $name = 'Активный';
                break;
            case Order::STATUS_WAIT:
                $name = 'Ожидает';
                break;
            case Order::STATUS_BUSY:
                $name = 'Занят';
                break;
            case Order::STATUS_CANCELED:
                $name = 'Отменен';
                break;
            case Order::STATUS_COMPLETED:
                $name = 'Выполнен';
                break;
            default:
                $name = 'Неизвестен';
                break;
        }

        return [
            'name' => $name,
            'code' => $code,
        ];
    }
}
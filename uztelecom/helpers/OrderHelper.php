<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use uztelecom\entities\orders\Order;
use yii\helpers\Html;

class OrderHelper
{
    public static function getStatusList()
    {
        return [
            Order::STATUS_ACTIVE => 'Активные',
            Order::STATUS_WAIT => 'Ожидающие',
            Order::STATUS_BUSY => 'Занятые',
            Order::STATUS_CANCELED => 'Отмененые',
            Order::STATUS_COMPLETED => 'Выполненые',
        ];
    }

    public static function getStatusLabel($status)
    {
        switch ($status) {
            case Order::STATUS_ACTIVE:
                $class = 'info';
                break;
            case Order::STATUS_WAIT:
                $class = 'warning';
                break;
            case Order::STATUS_BUSY:
                $class = 'danger';
                break;
            case Order::STATUS_CANCELED:
                $class = 'default';
                break;
            case Order::STATUS_COMPLETED:
                $class = 'success';
                break;
            default:
                $class = 'default';
                break;
        }
        return Html::tag('span',self::getStatusList()[$status] ?? 'Неизвестен',['class' => "label label-$class"]);
    }
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
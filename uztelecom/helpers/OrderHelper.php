<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\Icon;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\LatLngBounds;
use dosamigos\leaflet\types\Point;
use dosamigos\leaflet\widgets\Map;
use uztelecom\entities\orders\Order;
use yii\helpers\Html;

class OrderHelper
{
    public static function getStatusList()
    {
        return [
            Order::STATUS_ACTIVE => 'Активный',
            Order::STATUS_WAIT => 'В ожидании',
            Order::STATUS_BUSY => 'В пути',
            Order::STATUS_CANCELED => 'Отменен',
            Order::STATUS_COMPLETED => 'Выполнен',
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

    /**
     * @param Order $order
     * @return string
     */
    public static function getMap(Order $order)
    {

        $center = new LatLng(['lat' => $order->from_lat, 'lng' => $order->from_lng]);
        $marker = new Marker(['latLng' => $center, 'popupContent' => $order->from_address]);
        $icon = new Icon(['iconUrl' => '/img/dotA.png']);
        $icon->setIconSize(new Point(['x' => 31, 'y' => 40]));
        $icon->setIconAnchor(new Point(['x' => 16, 'y' => 5]));
        $marker->setIcon($icon);
        $markers[] = $marker;

        if ($order->to_lat && $order->to_lng) {
            $center = new LatLng(['lat' => $order->to_lat, 'lng' => $order->to_lng]);
            $marker = new Marker(['latLng' => $center, 'popupContent' => $order->to_address]);
            $icon = new Icon(['iconUrl' => '/img/dotB.png']);
            $icon->setIconSize(new Point(['x' => 41, 'y' => 52]));
            $icon->setIconAnchor(new Point(['x' => 16, 'y' => 5]));
            $marker->setIcon($icon);
            $markers[] = $marker;
            $bounds = new LatLngBounds([
                'southWest' => new LatLng(['lat' => $order->from_lat, 'lng' => $order->from_lng]),
                'northEast' => new LatLng(['lat' => $order->to_lat, 'lng' => $order->to_lng])
            ]);
        }

        $tileLayer = new TileLayer([
            'urlTemplate' => 'https://map.uztelecom.uz/hot/{z}/{x}/{y}.png',
        ]);

        $leaflet = new LeafLet([
            'center' => $center,
            'clientOptions' => [
                'bounds' => !empty($bounds) ? $bounds->encode() : null
            ],
        ]);

        foreach ($markers as $marker) {
            $leaflet->addLayer($marker);
        }
        $leaflet->addLayer($tileLayer);
        try {
            $result = Map::widget(['leafLet' => $leaflet, 'height' => '550px']);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }
        return $result;
    }
}
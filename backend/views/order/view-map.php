<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var $this \yii\web\View
 * @var $order \uztelecom\entities\orders\Order
 */

use dosamigos\leaflet\layers\Marker;
use dosamigos\leaflet\layers\TileLayer;
use dosamigos\leaflet\LeafLet;
use dosamigos\leaflet\types\Icon;
use dosamigos\leaflet\types\LatLng;
use dosamigos\leaflet\types\LatLngBounds;
use dosamigos\leaflet\types\Point;
use dosamigos\leaflet\widgets\Map;


$this->title = 'Маршрут на карте';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
    echo Map::widget(['leafLet' => $leaflet, 'height' => '550px']);
} catch (\Exception $e) {
    echo $e->getMessage();
}


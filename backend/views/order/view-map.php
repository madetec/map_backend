<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var $this \yii\web\View
 * @var $order \uztelecom\entities\orders\Order
 */
use yii\helpers\Html;

$this->title = 'Маршрут на карте';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$LocationA = json_encode([
    $order->from_lat,
    $order->from_lng,
]);

$LocationB = json_encode([
    $order->to_lat,
    $order->to_lng,
]);

$imgLayerA = (string)"'" . Html::img('/img/dotA.png', ['style' => 'height: 24px;']) . ' ' . $order->from_address . "'";
$imgLayerB = (string)"'" . Html::img('/img/dotB.png', ['style' => 'height: 24px;']) . ' ' . $order->to_address . "'";

echo Html::tag('div', null, ['id' => 'map']);

$script = <<<JS
$('#map').css('height','500px');
let aIcon,
    bIcon,
    aLayer,
    bLayer,
    map,
    overlayMaps;

aIcon = L.icon({
  iconUrl: '/img/dotA.png',
  iconSize: [31, 40],
  iconAnchor: [16, 37],
  popupAnchor: [0, -37]
}),

bIcon = L.icon({
  iconUrl: '/img/dotB.png',
  iconSize: [41, 52],
  iconAnchor: [16, 37],
  popupAnchor: [0, -37]
});
aLayer = L.marker($LocationA, {icon: aIcon})
.bindPopup($imgLayerA)
.openPopup();

bLayer = L.marker($LocationB, {icon: bIcon})
.bindPopup($imgLayerB)
.openPopup();

map = L.map('map', {
  center: [0, 0],
  zoom: 0,
    layers: [aLayer, bLayer]
});
overlayMaps = {
  $imgLayerA: aLayer,
  $imgLayerB: bLayer
};

L.control.layers(null, overlayMaps, {
  collapsed: false
}).addTo(map);

L.tileLayer('https://map.uztelecom.uz/hot/{z}/{x}/{y}.png').addTo(map);

var bounds = new L.LatLngBounds([$LocationA,$LocationB]);
map.fitBounds(bounds);
var zoom = map.getBoundsZoom(bounds);

map.setZoom(zoom-1)
JS;

$this->registerJs($script);


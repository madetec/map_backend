<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var $this \yii\web\View
 * @var $order \uztelecom\entities\orders\Order
 */

use uztelecom\helpers\OrderHelper;

$this->title = 'Маршрут на карте';
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo OrderHelper::getMap($order);
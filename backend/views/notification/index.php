<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 *
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel \backend\forms\NotificationSearch
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Уведомление';
$this->params['breadcrumbs'][] = $this->title;

$templateArr = [
    Html::beginTag('div', ['class' => 'row']),
    Html::beginTag('div', ['class' => 'col-md-12']),
    Html::beginTag('div', ['class' => 'box']),
    Html::beginTag('div', ['class' => 'box-header']),
    Html::tag('div', '{pager}', ['class' => 'box-tools']),
    Html::endTag('div'),
    Html::beginTag('div', ['class' => 'table-responsive']),
    Html::tag('div', '{items}', ['class' => 'box-body no-padding']),
    Html::endTag('div'),
    Html::endTag('div'),
    Html::endTag('div'),
    Html::endTag('div'),
];
try {
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => implode("\n", $templateArr),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'from_id'
            ],
            [
                'attribute' => 'item_id'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
}catch (\Exception $e){
    echo $e->getMessage();
}


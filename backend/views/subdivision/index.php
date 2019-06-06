<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\SubdivisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Филиалы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdivision-index">
    <p>
        <?= Html::a('Добавить филиал', ['create'], ['class' => 'btn btn-telecom-car btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function (\uztelecom\entities\Subdivision $subdivision) {
                    return Html::a($subdivision->name, \yii\helpers\Url::to(['subdivision/view', 'id' => $subdivision->id]));
                },
                'format' => 'raw'
            ],
            'lat',
            'lng',
            'address',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

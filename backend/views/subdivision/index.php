<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\SubdivisionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Филиалы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
    <p>
        <?= Html::a('Добавить филиал', ['create'], ['class' => 'btn btn-telecom-car btn-success']) ?>
    </p>
        <div class="box-body">
            <div class="table-responsive">
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
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'white-space: normal;'],
                        ],
                        'lat',
                        'lng',
                        [
                            'attribute' => 'address',
                            'contentOptions' => ['style' => 'white-space: normal;'],
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

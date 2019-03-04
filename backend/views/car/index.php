<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel uztelecom\forms\cars\CarSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <?= Html::a('Create Car', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="box-body">
        <div class="table-responsive">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'user_id',
                        'value' => function (\uztelecom\entities\cars\Car $model) {
                            return Html::a($model->user->profile->fullName, ['user/view', 'id' => $model->user->id]);
                        },
                        'format' => 'raw'
                    ],
                    'model',
                    [
                        'attribute' => 'color_id',
                        'value' => function (\uztelecom\entities\cars\Car $model) {
                            return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-car', 'style' => 'color: ' . $model->color->hex . ';']) . ' ' . $model->color->name);
                        },
                        'format' => 'raw'
                    ],
                    'number',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>

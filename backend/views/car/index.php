<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel uztelecom\forms\cars\CarSearchForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Машины';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-telecom-car"><i class="fa fa-car"></i>
            Добавить машину</a>
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
                        'value' => function (\uztelecom\entities\cars\Car $car) {
                            return Html::a($car->user->profile->fullName, ['user/view', 'id' => $car->user->id]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'model',
                        'value' => function (\uztelecom\entities\cars\Car $car) {
                            return Html::a($car->model, ['view', 'id' => $car->id]);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'color_id',
                        'value' => function (\uztelecom\entities\cars\Car $car) {
                            return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-car', 'data-color' => $car->color->hex, 'style' => 'color: ' . $car->color->hex . ';']) . ' ' . $car->color->name);
                        },
                        'filter' => $searchModel->colors,
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'number',
                        'value' => function (\uztelecom\entities\cars\Car $car) {
                            return \uztelecom\helpers\CarHelper::formatCarNumber($car->number);
                        },
                        'format' => 'raw'
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
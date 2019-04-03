<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$templateArr = [
    Html::beginTag('div', ['class' => 'row']),
    Html::beginTag('div', ['class' => 'col-md-12']),
    Html::beginTag('div', ['class' => 'box']),
    Html::beginTag('div', ['class' => 'box-header']),
    Html::a(
            Html::tag('i',null,['class'=>'ion ion-ios-personadd']) .' Добавить пользователя',
            ['create'],
            ['class' => 'btn btn-social btn-telecom-car']
    ),
    Html::tag('div', '{pager}', ['class' => 'box-tools']),
    Html::endTag('div'),
    Html::beginTag('div', ['class' => 'table-responsive']),
    Html::tag('div', '{items}', ['class' => 'box-body no-padding']),
    Html::endTag('div'),
    Html::endTag('div'),
    Html::endTag('div'),
    Html::endTag('div'),
];

echo  GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => implode("\n", $templateArr),
                'rowOptions' => function (\uztelecom\entities\user\User $model, $index, $widget, $grid){
                    switch ($model->status){
                        case \uztelecom\entities\user\User::STATUS_ACTIVE:
                            return ['class' => 'info'];
                        case \uztelecom\entities\user\User::STATUS_BLOCKED:
                            return ['class' => 'danger'];
                        case \uztelecom\entities\user\User::STATUS_DELETED:
                            return ['class' => 'default'];
                    }
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'fullName',
                        'value' => function (\uztelecom\entities\user\User $model) {
                            return \yii\helpers\Html::a($model->profile->fullName, ['user/view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'username',
                    [
                        'attribute' => 'role',
                        'value' => function (\uztelecom\entities\user\User $model) {
                            return \uztelecom\helpers\UserHelper::getRoleName($model->role);
                        },
                        'filter' => \yii\helpers\Html::activeDropDownList(
                            $searchModel,
                            'role',
                            $searchModel->rolesList(),
                            ['class' => 'form-control', 'prompt' => 'Все']),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function (\uztelecom\entities\user\User $model) {
                            return \uztelecom\helpers\UserHelper::getStatusName($model->status);
                        },
                        'format' => 'raw',
                        'filter' => \yii\helpers\Html::activeDropDownList(
                            $searchModel,
                            'status',
                            \uztelecom\helpers\UserHelper::getStatusList(),
                            ['class' => 'form-control', 'prompt' => 'Все']),
                    ],
                    [
                        'attribute' => 'subdivision',
                        'value' => function (\uztelecom\entities\user\User $model) {
                            return $model->profile->subdivision->name;
                        },
                        'format' => 'raw',
                        'filter' => \yii\helpers\Html::activeDropDownList(
                            $searchModel,
                            'subdivision',
                            $searchModel->subdivisionsList(),
                            ['class' => 'form-control', 'prompt' => 'Все подразделение']),
                    ],
                    'created_at:date',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);

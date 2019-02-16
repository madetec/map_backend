<?php

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header">
        <a href="<?= \yii\helpers\Url::to(['create']) ?>" class="btn btn-telecom-car"><i class="fa fa-user-plus"></i>
            Добавить пользователя</a>
    </div>
    <div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    'status',
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
    ]); ?>
    </div>
</div>

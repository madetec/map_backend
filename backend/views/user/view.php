<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model uztelecom\entities\user\User */
/* @var $phone uztelecom\entities\user\Phone*/

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<!--    <pre>-->
<!--        --><?php //print_r($model)?>
<!--    </pre>-->

    <?= DetailView::widget([
        'model' => $model,
//        'phone' => $phone,
        'attributes' => [
            'id',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'username',
            'status',
            'role',
            'created_at',
            'updated_at',
//            'phone',
        ],
    ]) ?>

</div>

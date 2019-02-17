<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model uztelecom\entities\user\User */

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>


<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model uztelecom\entities\user\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


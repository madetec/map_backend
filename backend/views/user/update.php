<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user uztelecom\entities\user\User */
/* @var $form uztelecom\forms\user\UserEditForm */

$this->title = 'Update User: ' . $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>

</div>

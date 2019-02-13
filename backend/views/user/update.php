<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user uztelecom\entities\user\User */
/* @var $form uztelecom\forms\user\UserEditForm */

$this->title = 'Update User: ' . $user->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>

</div>

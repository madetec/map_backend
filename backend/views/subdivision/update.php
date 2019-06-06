<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model uztelecom\entities\Subdivision */

$this->title = 'Update Subdivision: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Subdivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subdivision-update">

    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>

</div>

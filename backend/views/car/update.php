<?php

/* @var $this yii\web\View */
/* @var $car uztelecom\entities\cars\Car */
/* @var $form uztelecom\forms\cars\CarForm */

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Машины', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $car->id, 'url' => ['view', 'id' => $car->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?= $this->render('_form', [
        'model' => $form,
    ]) ?>
</div>

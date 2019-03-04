<?php

/* @var $this yii\web\View */
/* @var $model uztelecom\forms\cars\CarForm */

$this->title = 'Добавить машину';
$this->params['breadcrumbs'][] = ['label' => 'Машины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>



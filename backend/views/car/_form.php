<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model uztelecom\forms\cars\CarForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-8">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'color_id')->dropDownList($model->colors) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'user_id')->dropDownList($model->drivers) ?>
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

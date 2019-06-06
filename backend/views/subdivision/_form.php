<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \uztelecom\forms\SubdivisionForm */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="box">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lat')->textInput(['type' => 'number', 'step' => "0.0000001"]) ?>

            <?= $form->field($model, 'lng')->textInput(['type' => 'number', 'step' => "0.0000001"]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
</div>
<?php ActiveForm::end(); ?>
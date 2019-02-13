<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \uztelecom\forms\user\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="col-md-4">
    <div class="box">
        <div class="box-header">
            <h3>User</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'role')->dropDownList($model->roles) ?>

        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="box">
        <div class="box-header">
            <h3>Profile</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model->profile, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'father_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'subdivision')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'position')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile->phone, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile->address, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-telecom-car btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

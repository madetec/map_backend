<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user uztelecom\entities\user\User */
/* @var $model uztelecom\forms\user\UserEditForm */

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>

<div class="col-md-8">
    <div class="box">
        <div class="box-header">
            <h3>Профиль</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model->profile, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'father_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model->profile, 'subdivision_id')->dropDownList($model->profile->subdivisionList()) ?>
            <?= $form->field($model->profile, 'position')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="box">
        <div class="box-header">
            <h3>Пользователь</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'role')->dropDownList($model->rolesList) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-telecom-car btn-block btn-success']) ?>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

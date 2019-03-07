<?php

use uztelecom\helpers\UserHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model uztelecom\entities\user\User */

$this->title = $model->profile->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="box">
        <div class="box-header">
            <?= Html::a(Html::tag('i', null, ['class' => 'fa fa-pencil']) . ' Редактировать',
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-telecom-car']) ?>

            <?= Html::a(Html::tag('i', null, ['class' => 'fa fa-trash']) . ' Удалить',
                ['delete', 'id' => $model->id],
                ['class' => 'btn btn-telecom-car-delete pull-right',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить?',
                        'method' => 'post',
                    ]]) ?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'username',
                            [
                                'attribute' => 'status',
                                'value' => \uztelecom\helpers\UserHelper::getStatusName($model->status),
                                'format' => 'raw'
                            ], [
                                'attribute' => 'role',
                                'value' => \uztelecom\helpers\UserHelper::getRoleName($model->role),
                                'format' => 'raw'
                            ],
                            'created_at:date',
                            'updated_at:date',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model->profile,
                        'attributes' => [
                            'name',
                            'last_name',
                            'father_name',
                            [
                                'attribute' => 'subdivision',
                                'value' => $model->profile->subdivision->name,
                            ],
                            'position',
                        ],
                    ]) ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6">
                    <?php if ($model->profile->phones): ?>
                        <table class="table table-striped table-bordered detail-view">
                            <tbody>
                            <tr>
                                <th colspan="2">Номера телефонов:</th>
                            </tr>
                            <?php foreach ($model->profile->phones as $phone): ?>
                                <tr>
                                    <td>
                                        <?= ($model->profile->isMainPhone($phone->id))
                                            ? '<b>' . UserHelper::formatPhone($phone->number) . '</b> ' . Html::tag('i', null, [
                                                'class' => 'fa fa-check text-success',
                                                'data-toggle' => 'popover',
                                                'title' => 'Основной номер',
                                                'data-content' => 'На этот номер будут приходить уведомления',
                                                'data-placement' => 'top',
                                                'style' => 'cursor: pointer;'
                                            ])
                                            : '<b>' . UserHelper::formatPhone($phone->number) . '</b>'; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <?= Html::a(
                                                Html::tag(
                                                    'i',
                                                    null,
                                                    ['class' => 'fa fa-long-arrow-down text-info']
                                                ),
                                                ['move-phone-down', 'id' => $model->id, 'phone_id' => $phone->id],
                                                [
                                                    'class' => 'btn btn-default'
                                                ]) ?>
                                            <?= Html::a(
                                                Html::tag(
                                                    'i',
                                                    null,
                                                    ['class' => 'fa  fa-close text-danger']
                                                ),
                                                ['delete-phone', 'id' => $model->id, 'phone_id' => $phone->id],
                                                [
                                                    'class' => 'btn btn-default'
                                                ]) ?>
                                            <?= Html::a(
                                                Html::tag(
                                                    'i',
                                                    null,
                                                    ['class' => 'fa fa-long-arrow-up text-info']
                                                ),
                                                ['move-phone-up', 'id' => $model->id, 'phone_id' => $phone->id],
                                                [
                                                    'class' => 'btn btn-default'
                                                ]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <table class="table table-striped table-bordered detail-view">
                        <tbody>
                        <tr>
                            <th colspan="3">Добавить номер:</th>
                        </tr>
                        <tr>
                            <?php $form = ActiveForm::begin(); ?>
                            <td>
                                <?= $form->field($phoneForm, 'number')
                                    ->textInput(['placeholder' => '+998 (97) 882 8282'])
                                    ->label(false) ?>
                            </td>
                            <td>
                                <div class="form-group">
                                    <?= Html::submitButton('Добавить', ['class' => 'btn btn-telecom-car btn-block btn-success']) ?>
                                </div>
                            </td>
                            <?php ActiveForm::end(); ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <?php if ($model->profile->addresses): ?>
                        <table class="table table-striped table-bordered detail-view">
                            <tbody>
                            <tr>
                                <th colspan="2">Адреса:</th>
                            </tr>
                            <?php foreach ($model->profile->addresses as $address): ?>
                                <tr>
                                    <td>
                                        <?= ($model->profile->isMainAddress($address->id))
                                            ? Html::tag('i', null, [
                                                'class' => 'fa fa-check text-success',
                                                'data-toggle' => 'popover',
                                                'title' => 'Основной адрес',
                                                'data-content' => 'На этот адрес будут приходить уведомления',
                                                'data-placement' => 'top',
                                                'style' => 'cursor: pointer;'
                                            ]) . ' <b>' . $address->name . '</b>'
                                            : $address->name; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <?= Html::a(
                                                Html::tag(
                                                    'i',
                                                    null,
                                                    ['class' => 'fa fa-long-arrow-down text-success']
                                                ),
                                                ['move-address-down', 'id' => $model->id, 'address_id' => $address->id],
                                                [
                                                    'class' => 'btn btn-default'
                                                ]) ?>
                                            <?= Html::a(
                                                Html::tag(
                                                    'i',
                                                    null,
                                                    ['class' => 'fa  fa-close text-success']
                                                ),
                                                ['delete-address', 'id' => $model->id, 'address_id' => $address->id],
                                                [
                                                    'class' => 'btn btn-default'
                                                ]) ?>
                                            <?= Html::a(
                                                Html::tag(
                                                    'i',
                                                    null,
                                                    ['class' => 'fa fa-long-arrow-up text-success']
                                                ),
                                                ['move-address-up', 'id' => $model->id, 'address_id' => $address->id],
                                                [
                                                    'class' => 'btn btn-default'
                                                ]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

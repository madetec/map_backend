<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model uztelecom\entities\Subdivision */

$this->title = 'Create Subdivision';
$this->params['breadcrumbs'][] = ['label' => 'Subdivisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdivision-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

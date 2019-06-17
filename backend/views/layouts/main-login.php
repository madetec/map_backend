<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
dmstr\web\AdminLteAsset::register($this);
backend\assets\AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page">
<?php $this->beginBody() ?>

    <?= $content ?>
<footer>
    <p><?= "AK «UZBEKTELECOM» " . date('Y') . ". All rights reserved" ?></p>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

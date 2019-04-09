<?php

use yii\helpers\Html;

/* @var $userDetails object */
/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Tcar</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown notifications-menu">
                    <?= \backend\widgets\NotificationWidget::widget(); ?>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/img/tcarLogo.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= $userDetails->fullName ?></span>

                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="/img/tcarLogo.png" class="img-circle"
                                 alt="User Image"/>
                            <p>
                                <?= $userDetails->fullName . ' - ' . $userDetails->role ?>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div>
                                <?= Html::a(
                                    'Выход из системы',
                                    ['/auth/sign-out'],
                                    ['data-method' => 'post', 'class' => 'btn btn-block btn-telecom-car btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

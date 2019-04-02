<?php
/* @var $userDetails object */
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/img/tcarLogo.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $userDetails->fullName ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Пользователи', 'icon' => 'ion ion-android-people', 'url' => ['/user']],
                    ['label' => 'Машины', 'icon' => 'ion ion-android-car', 'url' => ['/car']],
                    ['label' => 'Заказы', 'icon' => 'ion ion-android-list', 'url' => ['/order']],
                ],
            ]
        ) ?>

    </section>

</aside>

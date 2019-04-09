<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * @var integer $count ;
 * @var \uztelecom\entities\notification\Notification[] $notifications ;
 */
$badge = $count ? \yii\helpers\Html::tag('span', $count, ['class' => 'label label-warning']) : "";
?>

<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="fa fa-bell-o"></i>
    <?= $badge ?>
</a>
<ul class="dropdown-menu">
    <?php if ($notifications): ?>
        <li class="header"><?= "Последние $count уведомлений." ?></li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <?php foreach ($notifications as $notification): ?>
                    <li>
                        <a href="">
                            <i class="fa fa-users text-aqua"></i>
                            <?= $notification->from->profile->fullName ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
        <li class="footer">
            <?php if ($notifications): ?>
                <a href="<?= \yii\helpers\Url::to(['notification/index']) ?>">Посмотреть все</a>
            <?php endif; ?>
        </li>
    <?php else: ?>
        <li class="header text-center"><?= "Нет новых уведомлений." ?></li>
    <?php endif; ?>


</ul>

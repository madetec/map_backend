<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace backend\widgets;


use uztelecom\readModels\NotificationReadModel;
use yii\base\Widget;

class NotificationWidget extends Widget
{
    const POS_TOP = 'top';
    public $position = self::POS_TOP;

    protected $notifications;

    public function __construct(NotificationReadModel $notificationReadModel, array $config = [])
    {
        $this->notifications = $notificationReadModel;
        parent::__construct($config);
    }

    /**
     * @return string|void
     * @throws \yii\base\InvalidArgumentException
     */
    public function init()
    {
        $notifications = $this->notifications->findAllNewNotifications(\Yii::$app->user->getId());
        echo $this->render(self::POS_TOP, [
            'count' => $notifications->count(),
            'notifications' => $notifications->limit(10)->all()
        ]);
    }
}
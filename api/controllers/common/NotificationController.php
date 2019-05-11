<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\controllers\common;


use api\providers\MapDataProvider;
use uztelecom\entities\notification\Notification;
use uztelecom\readModels\NotificationReadModel;
use yii\rest\Controller;

class NotificationController extends Controller
{
    public $notifications;

    public function __construct(
        string $id,
        $module,
        NotificationReadModel $notificationReadModel,
        array $config = [])
    {
        $this->notifications = $notificationReadModel;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return MapDataProvider
     */
    public function actionIndex()
    {
        $dataProvider = $this->notifications->findAllByUserId(\Yii::$app->user->getId());
        return new MapDataProvider($dataProvider, [$this, 'serializeView']);
    }


    public function serializeView(Notification $notification)
    {
        return [
            'from' => [
                'name' => $notification->from->profile->getFullName(),
                'role' => $notification->from->role,
                'main_phone' => $notification->from->profile->mainPhone,
                'car' => $notification->from->car
            ],
            'body' => $notification->typeData,
            'created_at' => $notification->created_at
        ];
    }
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\controllers\common;


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

    public function actionIndex()
    {
        return $this->notifications->findAllByUserId(\Yii::$app->user->getId());
    }
}
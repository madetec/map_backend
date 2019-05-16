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
     * @SWG\Get(
     *     path="/notifications",
     *     tags={"Notifications"},
     *     description="Returns notifications list",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *          @SWG\Schema(@SWG\Items(ref="#/definitions/Notification"))
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
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
                'main_phone' => $notification->from->profile->mainPhone->number,
                'car' => $notification->from->car,
                'position' => $notification->from->profile->position,
                'subdivision' => $notification->from->profile->subdivision->name,
            ],
            'body' => $notification->item,
            'created_at' => $notification->created_at
        ];
    }
}

/**
 * @SWG\Definition(
 *     definition="Notification",
 *     type="object",
 *     @SWG\Property(property="from", type="object",
 *          @SWG\Property(property="name", type="string"),
 *          @SWG\Property(property="role", type="string"),
 *          @SWG\Property(property="main_phone", type="string"),
 *          @SWG\Property(property="car", type="string"),
 *          @SWG\Property(property="position", type="string"),
 *          @SWG\Property(property="subdivision", type="string"),
 *     ),
 *     @SWG\Property(property="body", type="object"),
 *     @SWG\Property(property="created_at", type="integer"),
 * )
 */
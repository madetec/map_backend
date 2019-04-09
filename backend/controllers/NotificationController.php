<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace backend\controllers;

use backend\forms\NotificationSearch;
use uztelecom\readModels\NotificationReadModel;
use yii\web\Controller;
use Yii;

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
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new NotificationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
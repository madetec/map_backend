<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace backend\controllers;


use backend\forms\OrderSearch;
use uztelecom\readModels\OrderReadRepository;
use uztelecom\services\OrderManageService;
use Yii;
use yii\web\Controller;

class OrderController extends Controller
{
    private $orders;
    private $service;

    public function __construct(
        string $id,
        $module,
        OrderReadRepository $orderReadRepository,
        OrderManageService $orderManageService,
        array $config = [])
    {
        $this->orders = $orderReadRepository;
        $this->service = $orderManageService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionViewMap($id)
    {
        $order = $this->orders->find($id);
        return $this->render('view-map', [
            'order' => $order
        ]);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $order = $this->orders->find($id);
        if ($order->isCanceled() || $order->isCompleted()) {
            $order->delete();
        } else {
            Yii::$app->session->setFlash('error', "Не возможно удалить! Заказ еще не завершен.");

        }

        return $this->redirect(['index']);
    }
}

<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\controllers\user;

use api\providers\MapDataProvider;
use uztelecom\entities\orders\Order;
use uztelecom\forms\orders\OrderForm;
use uztelecom\helpers\OrderHelper;
use uztelecom\readModels\OrderReadRepository;
use uztelecom\services\OrderManageService;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

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
     * @return MapDataProvider
     */
    public function actionIndex()
    {
        $dataProvider = $this->orders->findAll(\Yii::$app->user->getId());
        return new MapDataProvider($dataProvider, [$this, 'serializeOrder']);
    }

    /**
     * @return array|OrderForm
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new OrderForm();
        $form->load(\Yii::$app->request->bodyParams, '');
        if ($form->validate()) {
            try {
                $order = $this->service->create(\Yii::$app->user->getId(), $form);
                return $this->serializeOrder($order);
            } catch (\Exception $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
        }
        return $form;
    }


    /**
     * @param Order $order
     * @return array
     */
    public function serializeOrder(Order $order)
    {
        return [
            'id' => $order->id,
            'from' => [
                'lat' => $order->from_lat,
                'lng' => $order->from_lng,
                'address' => $order->from_address,
            ],
            'to' => [
                'lat' => $order->to_lat,
                'lng' => $order->to_lng,
                'address' => $order->to_address,
            ],
            'created_at' => $order->created_at,
            'status' => OrderHelper::serializeStatus($order->status),
            'driver' => !$order->driver ? null : [
                'id' => $order->driver->id,
                'name' => $order->driver->profile->fullName,
                'car' => [
                    'id' => $order->driver->car->id,
                    'model' => $order->driver->car->model,
                    'number' => $order->driver->car->number,
                    'color' => [
                        'name' => $order->driver->car->color->name,
                        'hex' => $order->driver->car->color->hex,
                    ],
                ]
            ]
        ];
    }
}
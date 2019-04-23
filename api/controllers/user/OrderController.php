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
     * @SWG\Get(
     *     path="/user/order/active",
     *     tags={"User Order"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success response"
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    /**
     * @return array|\yii\db\ActiveRecord|null
     */
    public function actionActive()
    {
        $order = $this->orders->findActiveOrder(\Yii::$app->user->getId());
        return $this->serializeOrder($order);
    }

    /**
     * @SWG\Patch(
     *     path="/user/order/{order_id}/cancel",
     *     tags={"User Order"},
     *     @SWG\Parameter(name="order_id", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="Success response"
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    /**
     * @param $order_id
     * @return bool
     * @throws BadRequestHttpException
     */
    public function actionCancel($order_id)
    {
        try {
            $this->service->canceled($order_id);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return true;
    }

    /**
     * @SWG\Get(
     *     path="/user/order",
     *     tags={"User Order"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(@SWG\Items(ref="#/definitions/serializeOrder"))
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    /**
     * @return MapDataProvider
     */
    public function actionIndex()
    {
        $dataProvider = $this->orders->findAll(\Yii::$app->user->getId());
        return new MapDataProvider($dataProvider, [$this, 'serializeOrder']);
    }

    /**
     * * @SWG\Post(
     *     path="/user/order",
     *     tags={"User Order"},
     *     @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          required=true,
     *          type="object",
     *          @SWG\Schema(ref="#/definitions/OrderForm")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/serializeOrder")
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
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
                'car' => !$order->driver->car ? null : [
                    'id' => $order->driver->car->id,
                    'model' => $order->driver->car->model,
                    'number' => $order->driver->car->number,
                    'color' => !$order->driver->car->color ? null : [
                        'name' => $order->driver->car->color->name,
                        'hex' => $order->driver->car->color->hex,
                    ],
                ]
            ]
        ];
    }
}


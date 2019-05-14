<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\controllers\driver;

use uztelecom\entities\orders\Order;
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
     * @param $order_id
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionIsWaiting($order_id)
    {
        try {
            $order = $this->service->isWaiting(\Yii::$app->user->getId(), $order_id);
            return $this->serializeOrder($order);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @param $order_id
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionStarted($order_id)
    {
        try {
            $order = $this->service->started(\Yii::$app->user->getId(), $order_id);
            return $this->serializeOrder($order);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @SWG\Patch(
     *     path="/driver/order/{order_id}/completed",
     *     tags={"Driver Order"},
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
    public function actionCompleted($order_id)
    {
        try {
            $this->service->completed($order_id);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return true;
    }


    /**
     * @SWG\Patch(
     *     path="/driver/order/{order_id}/take",
     *     tags={"Driver Order"},
     *     @SWG\Parameter(name="order_id", in="path", required=true, type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/serializeOrder")
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    /**
     * @param $order_id
     * @return array|bool
     * @throws BadRequestHttpException
     */
    public function actionTake($order_id)
    {
        try {
            $order = $this->service->takeOrder(\Yii::$app->user->getId(), $order_id);
            return $this->serializeOrder($order);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @SWG\Patch(
     *     path="/driver/order/{order_id}/cancel",
     *     tags={"Driver Order"},
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
            'completed_at' => $order->completed_at,
            'status' => OrderHelper::serializeStatus($order->status),
            'user' => [
                'id' => $order->user->id,
                'name' => $order->user->profile->fullName,
            ],
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


/**
 * @SWG\Definition(
 *     definition="serializeOrder",
 *     type="object",
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="from", type="object",
 *          @SWG\Property(property="lat", type="integer"),
 *          @SWG\Property(property="lng", type="integer"),
 *          @SWG\Property(property="address", type="string"),
 *     ),
 *     @SWG\Property(property="to", type="object",
 *          @SWG\Property(property="lat", type="integer"),
 *          @SWG\Property(property="lng", type="integer"),
 *          @SWG\Property(property="address", type="string"),
 *     ),
 *     @SWG\Property(property="created_at", type="integer"),
 *     @SWG\Property(property="completed_at", type="integer"),
 *     @SWG\Property(property="status", type="object",
 *          @SWG\Property(property="name", type="string"),
 *          @SWG\Property(property="code", type="integer"),
 *     ),
 *     @SWG\Property(property="user", type="object",
 *          @SWG\Property(property="id", type="integer"),
 *          @SWG\Property(property="name", type="string"),
 *     ),
 *     @SWG\Property(property="driver", type="object",
 *          @SWG\Property(property="id", type="integer"),
 *          @SWG\Property(property="name", type="string"),
 *          @SWG\Property(property="car", type="object",
 *                @SWG\Property(property="id", type="integer"),
 *                @SWG\Property(property="model", type="string"),
 *                @SWG\Property(property="number", type="string"),
 *                @SWG\Property(property="color", type="object",
 *                      @SWG\Property(property="name", type="string"),
 *                      @SWG\Property(property="hex", type="string"),
 *                )
 *          ),
 *     ),
 * )
 *
 * @SWG\Definition(
 *     definition="OrderForm",
 *     type="object",
 *     @SWG\Property(property="from_lat", type="number"),
 *     @SWG\Property(property="from_lng", type="number"),
 *     @SWG\Property(property="from_address", type="string"),
 *     @SWG\Property(property="to_lat", type="number"),
 *     @SWG\Property(property="to_lng", type="number"),
 *     @SWG\Property(property="to_address", type="string"),
 * )
 */
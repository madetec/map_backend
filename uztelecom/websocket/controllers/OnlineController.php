<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket\controllers;

use Ratchet\ConnectionInterface;
use uztelecom\entities\orders\Order;
use uztelecom\forms\orders\OrderForm;
use uztelecom\helpers\OrderHelper;
use uztelecom\readModels\UserReadRepository;
use uztelecom\repositories\UserRepository;
use uztelecom\services\OrderManageService;
use uztelecom\websocket\components\AuthComponent;
use yii\helpers\ArrayHelper;


class OnlineController extends AuthComponent
{
    private $users;
    private $orderService;

    public function __construct(
        UserRepository $userRepository,
        OrderManageService $orderManageService,
        array $config = []
    )
    {
        parent::__construct($config);
        $this->users = $userRepository;
        $this->orderService = $orderManageService;
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = (object)$this->decodeMessage($msg);
        if ($action = $this->getMethodName($message->action)) {
            try {
                $this->{$action}($from, $message->data);
            } catch (\Error $e) {
                $this->send($from, $message->action, 'error', 'action not found! ' . $e->getMessage());
            } catch (\Exception $e) {
                $this->send($from, $message->action, 'error', 'action not found! ' . $e->getMessage());
            }
        } else {
            $this->send($from, $message->action, 'error', 'action not found!');
        }
    }


    /**
     * @param ConnectionInterface $from
     * @param $data
     * @throws \yii\base\InvalidArgumentException
     */
    protected function createOrder(ConnectionInterface $from, $data)
    {
        $result = null;
        $main = $this->service->getClient($from->resourceId);
        $form = new OrderForm();
        $form->load($data, '');
        try {
            $form->validate();
            try {
                $order = $this->orderService->create($main->user->id, $form);
                $this->send($from, 'createOrder', 'success', $this->serializeOrder($order));
            } catch (\Exception $e) {
                $this->send($from, 'createOrder', 'error', $e->getMessage());
            }
        } catch (\Exception $e) {
            $this->send($from, 'createOrder', 'error', $e->getMessage());
        }
        $this->send($from, 'createOrder', 'error', $form);
    }


    protected function coordinates(ConnectionInterface $from, $coordinates)
    {
        $main = $this->service->getClient($from->resourceId);
        $coordinates = (object)$coordinates;
        $main->coordinates->lat = $coordinates->lat;
        $main->coordinates->lng = $coordinates->lng;
    }


    protected function onlineUsers(ConnectionInterface $from)
    {
        $totalUsers = (new UserReadRepository())->getAllUsersCount();
        $totalDrivers = (new UserReadRepository())->getAllDriverCount();

        $resultData = [
            'online' => [
                'users' => [],
                'drivers' => []
            ],
            'offline' => [
                'users' => (int)$totalUsers,
                'drivers' => (int)$totalDrivers
            ],
        ];
        $users = $this->service->getAllWithoutThis($from);
        foreach ($users as $user) {
            if ($user->user->role === 'driver') {
                $resultData['online']['drivers'][] = [
                    'id' => $user->user->id,
                    'coordinates' => [
                        'lat' => $user->coordinates->lat,
                        'lng' => $user->coordinates->lng,
                    ]
                ];
                $resultData['offline']['drivers']--;
            } elseif ($user->user->role === 'user') {
                $resultData['online']['users'][] = [
                    'id' => $user->user->id,
                    'coordinates' => [
                        'lat' => $user->coordinates->lat,
                        'lng' => $user->coordinates->lng,
                    ]
                ];
                $resultData['offline']['users']--;
            }

        }
        $this->send($from, 'onlineUsers', 'success', $resultData);
    }

    /**
     * @param ConnectionInterface $from
     * @throws \yii\base\InvalidArgumentException
     */
    protected function ping(ConnectionInterface $from)
    {
        $this->send($from,'ping', 'success', 'pong');
    }

    private function getMethodName($action)
    {
        return ArrayHelper::getValue($this->urlManager(), $action);
    }


    private function urlManager()
    {
        return [
            'ping' => 'ping',
            'onlineUsers' => 'onlineUsers',
            'coordinates' => 'coordinates',
            'createOrder' => 'createOrder',
            'takeOrder' => 'takeOrder',
            'waitingOrder' => 'waitingOrder',
            'startedOrder' => 'startedOrder',
            'completedOrder' => 'completedOrder',
            'cancelOrder' => 'cancelOrder',
        ];
    }


    private function serializeOrder(Order $order)
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

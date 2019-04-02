<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket\controllers;

use Ratchet\ConnectionInterface;
use uztelecom\readModels\UserReadRepository;
use uztelecom\repositories\UserRepository;
use uztelecom\websocket\components\AuthComponent;
use yii\helpers\ArrayHelper;


class OnlineController extends AuthComponent
{
    private $users;

    public function __construct(
        UserRepository $userRepository,
        array $config = []
    )
    {
        parent::__construct($config);
        $this->users = $userRepository;
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


    protected function coordinates(ConnectionInterface $from, $coordinates)
    {
        $main = $this->service->getClient($from->resourceId);
        $users = $this->service->getAllWithoutThis($from);

        $message = [
            'userId' => $main->user->id,
            'coordinates' => $coordinates,
        ];

        foreach ($users as $user) {
            $this->send($user->client, 'coordinates', 'success', $message);
        }
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
                    'id' => $user->user->id
                ];
                $resultData['offline']['drivers']--;
            } elseif ($user->user->role === 'user') {
                $resultData['online']['users'][] = [
                    'id' => $user->user->id
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
        ];
    }
}

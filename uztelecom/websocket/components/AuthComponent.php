<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket\components;

use uztelecom\entities\user\User;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use uztelecom\websocket\UsersWs;
use yii\helpers\Json;

class AuthComponent implements MessageComponentInterface
{
    protected $service;

    public function __construct(array $config = [])
    {
        $this->service = new UsersWs();
    }


    /**
     * @param ConnectionInterface $conn
     * @throws \yii\base\InvalidArgumentException
     * @throws \yii\db\Exception
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $query = $conn->WebSocket->request->getQuery()->toArray();
        $userId = $query['user_id'] ?? null;

        try {
            echo PHP_EOL . 'check mysql' . PHP_EOL;
            \Yii::$app->db->createCommand('SELECT 1')->query();
            echo PHP_EOL . 'mysql connected' . PHP_EOL;
        } catch (\yii\db\Exception $exception) {
            \Yii::$app->db->close();
            echo PHP_EOL . 'mysql connect close' . PHP_EOL;
            \Yii::$app->db->open();
            echo PHP_EOL . 'mysql connect open' . PHP_EOL;
        }

        try {
            if(!$userId){
                throw new \LogicException('UserId not found. Unauthorized');
            }
            $user = User::findOne($userId);
            if ($user) {
                $this->service->attach($conn, $user);
                $this->send($conn, 'auth', 'success', 'connected');
            } else {
                $this->send($conn, 'auth', 'error', 'Unauthorized!');
                $conn->close();
            }
        } catch (\Exception $exception) {
            $this->send($conn, 'auth', 'error', $exception->getMessage());
            $conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->service->detach($conn->resourceId);
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->service->detach($conn->resourceId);
    }

    /**
     * @param ConnectionInterface $to
     * @param $action
     * @param $status
     * @param $message
     * @throws \yii\base\InvalidArgumentException
     */
    protected function send(ConnectionInterface $to, $action, $status, $message)
    {
        $to->send(Json::encode([
            'action' => $action,
            'status' => $status,
            'data' => $message,
        ]));
    }

    /**
     * @param $message
     * @return mixed
     * @throws \yii\base\InvalidArgumentException
     */
    protected function decodeMessage($message)
    {
        return Json::decode($message);
    }

    protected function getUserData(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->profile->getFullName(),
            'role' => $user->roleName
        ];
    }
}
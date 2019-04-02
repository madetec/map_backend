<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket;

use uztelecom\entities\user\User;
use consik\yii2websocket\events\WSClientEvent;
use consik\yii2websocket\WebSocketServer;
use Ratchet\ConnectionInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class AppWs extends WebSocketServer
{
    protected $service;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->service = new UsersWs();
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_CLIENT_CONNECTED, function (WSClientEvent $e) {
            $query = $e->client->WebSocket->request->getQuery()->toArray();
            $user_id = $query['user_id'] ?? null;
            try {
                $user = User::findOne($user_id);
                if ($user) {
                    $this->service->attach($e->client, $user);
                    $client = $this->service->getClient($e->client->resourceId);
                    $e->client->send(
                        $this->encodeMessage('connection', 'hello, ' . $client->user->profile->name)
                    );
                } else {
                    $e->client->send('Unauthorized!');
                    $e->client->close();
                }
            } catch (\Exception $exception) {
                $e->client->send($exception->getMessage());
//                $e->client->close();
            }
        });

        $this->on(self::EVENT_CLIENT_DISCONNECTED, function (WSClientEvent $e) {
            $this->service->detach($e->client->resourceId);
        });
    }

    /**
     * @param ConnectionInterface $from
     * @param $msg
     * @return null|string
     * @throws \yii\base\InvalidArgumentException
     */
    protected function getCommand(ConnectionInterface $from, $msg)
    {
        $request = Json::decode($msg, true);
        return !empty($request['action']) ? $request['action'] : parent::getCommand($from, $msg);
    }

    /**
     * @param ConnectionInterface $client
     * @param $msg
     * @throws \yii\base\InvalidArgumentException
     */
    public function commandOnline(ConnectionInterface $client, $msg)
    {
        $onlineUsers = ArrayHelper::getColumn($this->service->getAllWithoutThis($client), function ($arr) {
            return $this->getUserData($arr->user);
        });

        $client->send($this->encodeMessage('online', $onlineUsers));
    }

    /**
     * @param ConnectionInterface $connection
     * @param $msg
     * @throws \yii\base\InvalidArgumentException
     */
    public function commandChat(ConnectionInterface $connection, $msg)
    {
        $message = (object)$this->decodeMessage($msg);
        $from = $this->service->getClient($connection->resourceId);
        $to = $this->service->getClientByUserId($message->to);
        $to->client->send($this->encodeMessage(
            'chat',
            $message->message,
            $this->getUserData($from->user)
        ));

        $from->client->send($this->encodeMessage(
            'chat',
            $message->message,
            null,
            $this->getUserData($from->user)
        ));
    }

    /**
     * @param $action
     * @param $message
     * @param null $from
     * @param null $to
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    private function encodeMessage($action, $message, $from = null, $to = null)
    {
        return Json::encode([
            'action' => $action,
            'message' => $message,
            'from' => $from,
            'to' => $to
        ]);
    }

    /**
     * @param $message
     * @return mixed
     * @throws \yii\base\InvalidArgumentException
     */
    private function decodeMessage($message)
    {
        return Json::decode($message);
    }

    private function getUserData(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->profile->getFullName(),
            'avatar' => $user->profile->getPhoto()
        ];
    }
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket\controllers;

use uztelecom\repositories\UserRepository;
use Ratchet\ConnectionInterface;
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
        ];
    }
}

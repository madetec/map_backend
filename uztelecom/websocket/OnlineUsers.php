<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket;


use Ratchet\ConnectionInterface;
use uztelecom\websocket\components\AuthComponent;
use yii\helpers\ArrayHelper;

class OnlineUsers extends AuthComponent
{
    public function onOpen(ConnectionInterface $conn)
    {
        parent::onOpen($conn);
        $onlineUsers = ArrayHelper::getColumn($this->service->getAllWithoutThis($conn), function ($arr) {
            return $this->getUserData($arr->user);
        });
        $conn->send($this->encodeMessage('/users', $onlineUsers));
    }
}
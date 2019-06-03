<?php
namespace uztelecom\websocket;
use Ratchet\ConnectionInterface;
use uztelecom\entities\user\User;

/**
 * Class WsClientUser
 * @package uztelecom\websocket
 * @property User $user
 * @property ConnectionInterface $client
 * @property object $coordinates
 */
class ClientUserWs
{
    public $client;
    public $user;
    public $coordinates = (object)[
        'lat' => null,
        'lng' => null,
    ];
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\websocket;


use Ratchet\ConnectionInterface;
use uztelecom\entities\user\User;
use yii\helpers\ArrayHelper;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class UsersWs
 * @package box\services\WebSocket
 * @property User $user
 * @property $users
 */
class UsersWs
{
    public $users = [];
    public $count;


    public function attach(ConnectionInterface $client, User $user, float $lat = 0, float $lng = 0)
    {
        $object = new ClientUserWs();
        $object->client = $client;
        $object->user = $user;
        $object->coordinates->lat = $lat;
        $object->coordinates->lnt = $lng;
        $this->users[$client->resourceId] = $object;
    }

    /**
     * @param $resourceId
     * @return ClientUserWs|null
     */
    public function getClient($resourceId): ?ClientUserWs
    {
        return !empty($this->users[$resourceId]) ? $this->users[$resourceId] : null;
    }

    public function getAll()
    {
        return $this->users;
    }

    public function getAllWithoutThis(ConnectionInterface $client)
    {
        $clients = $this->users;
        unset($clients[$client->resourceId]);
        return $clients;
    }


    public function getClientByUserId($id)
    {
        $clients = $this->users;
        $current = null;
        foreach ($clients as $client) {
            if ($client->user->id == $id) {
                $current = $client;
            }
        }
        return $current;
    }

    /**
     * @param $ids
     * @return array|null
     * @throws \yii\base\InvalidArgumentException
     */
    public function getClientsByUserIds($ids)
    {
        $clients = $this->users;
        $currents = null;
        foreach ($clients as $client) {
            if (ArrayHelper::isIn($client->user->id, $ids)) {
                $currents[] = $client;
            }
        }
        return $currents;
    }


    public function detach($resourceId)
    {
        $clients = $this->users;

        foreach ($clients as $k => $client){
            if($client->client->resourceId == $resourceId)
            {
                unset($clients[$k]);
                $this->users = $clients;
                return;
            }
        }

    }
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities\user;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class Device
 * @package uztelecom\entities\user
 * @property integer $user_id,
 * @property string $firebase_token,
 * @property string $uid,
 * @property string $name,
 *
 * @unique $uid
 * @index $user_id, $firebase_token
 *
 * @property User $user
 */
class Device extends ActiveRecord
{

    public static function create($firebase_token, $uid, $name)
    {
        $device = new static();
        $device->firebase_token = $firebase_token;
        $device->uid = $uid;
        $device->name = $name;
        return $device;
    }

    public function isEqualTo($uid, $firebase_token)
    {
        return $this->uid === $uid && $this->firebase_token === $firebase_token;
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function tableName(): string
    {
        return '{{%user_devices}}';
    }
}
<?php


namespace uztelecom\entities\user;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 20:25
 * @property User $user
 * @property Phone[] $phones
 * @property Address[] $addresses
 *
 */
class Profile extends ActiveRecord
{
    public static function tableName()
    {

        return '{{%profiles}}';
    }

    public function getUser(): ActiveQuery
    {

        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPhones(): ActiveQuery
    {
        return $this->hasMany(Phone::class, ['profile_id' => 'id']);
    }

    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(Address::class, ['profile_id' => 'id']);
    }


}
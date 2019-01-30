<?php


namespace uztelecom\entities\user;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
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
    public static function create($name, $last_name, $father_name, $subdivision, $position)
    {
        $profile = new static();
        $profile->name = $name;
        $profile->last_name = $last_name;
        $profile->father_name = $father_name;
        $profile->subdivision = $subdivision;
        $profile->position = $position;
        return $profile;

    }
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


    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['phones', 'addresses']
            ]
        ];
    }


}
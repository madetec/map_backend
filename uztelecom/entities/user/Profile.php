<?php


namespace uztelecom\entities\user;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use uztelecom\entities\Subdivision;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 20:25
 * @property string $name
 * @property string $last_name
 * @property string $father_name
 * @property string $subdivision_id
 * @property string $position
 * @property User $user
 * @property Phone[] $phones
 * @property Address[] $addresses
 * @property string $fullName
 * @property Subdivision $subdivision
 *
 */
class Profile extends ActiveRecord
{
    public static function create($name, $last_name, $father_name, $subdivision_id, $position)
    {
        $profile = new static();
        $profile->name = $name;
        $profile->last_name = $last_name;
        $profile->father_name = $father_name;
        $profile->subdivision_id = $subdivision_id;
        $profile->position = $position;
        return $profile;

    }

    public function edit($name, $last_name, $father_name, $subdivision_id, $position)
    {
        $this->name = $name;
        $this->last_name = $last_name;
        $this->father_name = $father_name;
        $this->subdivision_id = $subdivision_id;
        $this->position = $position;
    }

    public function getSubdivision(): ActiveQuery
    {
        return $this->hasOne(Subdivision::class, ['id' => 'subdivision_id']);
    }

    public function getFullName()
    {
        $fullName = $this->last_name . ' ' . $this->name;
        $fullName = $this->father_name ? $fullName . ' ' . $this->father_name : $fullName;
        return $fullName;
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
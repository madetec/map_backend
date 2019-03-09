<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 20:34
 */

namespace uztelecom\entities\user;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $name
 * @property integer $sort
 * @property integer $profile_id
 * @property float $lat
 * @property float $lng
 */
class Address extends ActiveRecord
{
    public static function create(string $name, float $lat = null, float $lng = null): self
    {
        $address = new static();
        $address->name = $name;
        $address->lat = $lat;
        $address->lng = $lng;
        return $address;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%addresses}}';
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

}
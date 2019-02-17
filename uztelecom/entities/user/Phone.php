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
 * Class Phone
 * @package uztelecom\entities\user
 * @property string $number
 */
class Phone extends ActiveRecord
{
    public static function create($number)
    {
        $phone = new static();
        $phone->number = $number;

        return $phone;
    }

    public static function tableName()
    {
        return '{{%phones}}';
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

}
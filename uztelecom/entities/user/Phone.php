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

class Phone extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%phones}}';
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

}
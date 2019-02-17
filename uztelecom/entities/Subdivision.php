<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities;


use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 */
class Subdivision extends ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%subdivisions}}';
    }

}
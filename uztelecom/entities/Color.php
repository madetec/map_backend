<?php

namespace uztelecom\entities;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property int $id
 * @property string $name
 * @property string $rgb
 * @property string $hex
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%colors}}';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'rgb' => 'Rgb',
            'hex' => 'Hex',
        ];
    }
}

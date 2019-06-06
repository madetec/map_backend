<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities;


use uztelecom\forms\SubdivisionForm;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $address
 */
class Subdivision extends ActiveRecord
{

    public static function create(SubdivisionForm $form)
    {
        $subdivision = new static();
        $subdivision->name = $form->name;
        $subdivision->lat = $form->lat;
        $subdivision->lng = $form->lng;
        $subdivision->address = $form->address;
        $subdivision->save();
        return $subdivision;
    }

    public function edit(SubdivisionForm $form)
    {
        $this->name = $form->name;
        $this->lat = $form->lat;
        $this->lng = $form->lng;
        $this->address = $form->address;
        $this->save();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'lng' => 'Долгота',
            'lat' => 'Широта',
            'address' => 'Адрес',
        ];
    }

    public static function tableName(): string
    {
        return '{{%subdivisions}}';
    }

}
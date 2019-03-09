<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use yii\base\Model;

/**
 * @property ProfileForm $profile
 */
class AddressForm extends Model
{
    public $name;
    public $lat;
    public $lng;

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string'],
            [['lat', 'lng'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Адрес',
        ];
    }

}
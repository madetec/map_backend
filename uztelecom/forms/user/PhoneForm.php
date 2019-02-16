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
class PhoneForm extends Model
{
    public $number;

    public function rules()
    {
        return [
            ['number', 'required'],
            ['number', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'number' => 'Номер телефона',
        ];
    }

}
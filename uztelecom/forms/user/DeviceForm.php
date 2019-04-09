<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\forms\user;


use yii\base\Model;

class DeviceForm extends Model
{
    public $uid;
    public $firebase_token;
    public $name;

    public function rules(): array
    {
        return [
            [['uid', 'firebase_token'], 'required'],
            [['uid', 'firebase_token', 'name'], 'string'],
        ];
    }
}
<?php

namespace uztelecom\forms\auth;

use uztelecom\entities\Subdivision;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class SignUpForm extends Model
{
    public $username;
    public $password;

    public $name;
    public $last_name;
    public $subdivision_id;
    public $position;

    public function rules()
    {
        return [
            [['username', 'password', 'name', 'last_name', 'subdivision_id', 'position'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'subdivision_id' => 'Подразделение',
            'position' => 'Должность',
        ];
    }

    /**
     * @return array
     */
    public function subdivisionsList(): array
    {
        return ArrayHelper::map(Subdivision::find()->asArray()->all(), 'id', 'name');
    }
}

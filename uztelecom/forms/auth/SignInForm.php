<?php

namespace uztelecom\forms\auth;

use uztelecom\entities\user\User;
use yii\base\Model;


class SignInForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @throws \yii\base\InvalidArgumentException
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByUsername($this->username);
            if (!$user || !$user->validatePassword($this->password)) {
                    $this->addError($attribute, 'Не верный логин или пароль');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}

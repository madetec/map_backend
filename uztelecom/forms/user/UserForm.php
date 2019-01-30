<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use uztelecom\forms\CompositeForm;

/**
 * @property ProfileForm $profile
 */
class UserForm extends CompositeForm
{
    public $username;
    public $password;

    public function __construct(array $config = [])
    {
        $this->profile = new ProfileForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [
                ['username', 'password'], 'required'
            ],
            [
                ['username', 'password'], 'string'
            ],

            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],

        ];
    }

    protected function internalForms(): array
    {
        return ['profile'];
    }

}
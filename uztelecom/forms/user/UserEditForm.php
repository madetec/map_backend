<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 02.02.2019
 * Time: 12:44
 *
 */

namespace uztelecom\forms\user;


use uztelecom\entities\user\User;
use uztelecom\forms\CompositeForm;
/**
 * @property ProfileForm $profile
 */
class UserEditForm extends CompositeForm
{
    public $username;
    public $password;

    public function __construct(User $user, $config = [])
    {
        $this->username = $user->username;
        $this->password = $user->password;
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
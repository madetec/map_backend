<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use uztelecom\entities\user\User;
use uztelecom\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * @property ProfileForm $profile
 * @property array $roles
 * @property array $rolesList
 */
class UserForm extends CompositeForm
{
    public $username;
    public $password;
    public $role;


    public function __construct(User $user = null, array $config = [])
    {
        if($user){
            $this->username = $user->username;
            $this->role = $user->role;
            $this->profile = new ProfileForm($user->profile);
        }else{
            $this->profile = new ProfileForm();
        }

        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
            ['role', 'in', 'range' => $this->rolesList]
        ];
    }

    protected function internalForms(): array
    {
        return ['profile'];
    }

    protected function getRolesList(): array
    {
        $roles = \Yii::$app->authManager->getRoles();
        $roles = ArrayHelper::getColumn($roles, 'name');
        return $roles;
    }

    protected function getRoles(): array
    {
        $roles = \Yii::$app->authManager->getRoles();
        $roles = ArrayHelper::getColumn($roles, function ($model) {
            switch ($model->name) {
                case 'user':
                    return 'Пользователь';
                case 'driver':
                    return 'Водитель';
                case 'admin':
                    return 'Диспечер';
                default:
                    return $model->name;
            }
        });
        return $roles;
    }

}
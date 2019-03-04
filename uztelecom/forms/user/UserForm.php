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
 * @property array $rolesFilter
 * @property array $rolesList
 */
class UserForm extends CompositeForm
{
    public $username;
    public $password;
    public $role;
    private $_user;


    public function __construct(User $user = null, array $config = [])
    {
        if($user){
            $this->_user = $user;
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
            ['username', 'unique', 'targetClass' => User::class,
                'filter' => $this->_user ? ['<>', 'id', $this->_user->id] : null
            ],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
            ['role', 'in', 'range' => $this->rolesFilter]
        ];
    }

    protected function internalForms(): array
    {
        return ['profile'];
    }
    public function getRolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function getRolesFilter()
    {
        return ArrayHelper::getColumn(\Yii::$app->authManager->getRoles(), 'name');
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'role' => 'Роль',
        ];
    }
}
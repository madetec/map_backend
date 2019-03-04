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
use yii\helpers\ArrayHelper;

/**
 * @property string $password
 * @property string $role
 * @property ProfileEditForm $profile
 * @property array $rolesFilter
 * @property array $rolesList
 */
class UserEditForm extends CompositeForm
{
    public $password;
    public $role;

    public function __construct(User $user, $config = [])
    {
        $this->role = $user->role;
        $this->profile = new ProfileEditForm($user->profile);
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['password', 'string'],
            ['role', 'in', 'range' => $this->rolesFilter]
        ];
    }

    public function getRolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function getRolesFilter()
    {
        return ArrayHelper::getColumn(\Yii::$app->authManager->getRoles(), 'name');
    }

    protected function internalForms(): array
    {
        return ['profile'];
    }
}
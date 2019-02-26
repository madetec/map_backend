<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use Symfony\Component\Routing\Exception\InvalidParameterException;
use uztelecom\entities\user\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class UserHelper
{
    public static function getName($user): string
    {
        /** @var $user User */
        return $user->username;
    }

    /**
     * @param $roleName
     * @return string
     * @throws InvalidParameterException
     */
    public static function getRoleName($roleName)
    {
        $authManager = \Yii::$app->authManager;
        if (!$role = $authManager->getRole($roleName)) {
            throw new InvalidParameterException('Role not found');
        }
        $name = ' ' . $role->description;
        switch ($roleName) {
            case 'user':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-street-view']) . $name);
            case 'driver':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-car']) . $name);
            case 'dispatcher':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-user']) . $name);
            case 'administrator':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-user']) . $name);
            default:
                return 'Пользователь';
        }
    }


    public static function getStatusName($status)
    {
        switch ($status) {
            case User::STATUS_DELETED:
                return Html::tag('i', 'Удален', ['class' => 'label label-default']);
            case User::STATUS_BLOCKED:
                return Html::tag('i', 'Заблокирован', ['class' => 'label label-warning']);
            case User::STATUS_ACTIVE:
                return Html::tag('i', 'Активный', ['class' => 'label label-success']);
            default:
                return Html::tag('i', 'Неизвестный', ['class' => 'label label-default']);
        }
    }

    public static function getRoleList()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public static function getStatusList()
    {
        return [
            User::STATUS_DELETED => 'Удалённые',
            User::STATUS_BLOCKED => 'Заблокированные',
            User::STATUS_ACTIVE => 'Активные',
        ];
    }


    public static function serializeRoles()
    {
        $roles = [];
        foreach (\Yii::$app->authManager->getRoles() as $role) {
            $roles[] = [
                'role' => $role->name,
                'name' => $role->description,
            ];
        }
        return $roles;
    }
}
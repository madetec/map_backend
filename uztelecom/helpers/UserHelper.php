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
    public static function getStatusButtons($user_id, $status)
    {
        $active = Html::a('Активировать', ['user/active', 'user_id' => $user_id], ['class' => 'btn btn-success']);
        $blocked = Html::a('Заблокировать', ['user/blocked', 'user_id' => $user_id], ['class' => 'btn btn-warning']);
        switch ($status) {
            case User::STATUS_DELETED:
                return "$active $blocked";
            case User::STATUS_BLOCKED:
                return "$active";
            case User::STATUS_ACTIVE:
                return "$blocked";
            case User::STATUS_BUSY:
                return "$active $blocked";
            default:
                return Html::tag('i', 'Неизвестный', ['class' => 'label label-default']);
        }
    }
    public static function formatPhone($phone)
    {
        $code = substr($phone, 0, 2);
        $prefix = substr($phone, 2, 3);
        $number = substr($phone, 5, 4);

        $logo = self::getOperatorLogo($code);

        return $logo . " +998 ($code) $prefix $number";
    }

    public static function getOperatorLogo($code)
    {
        switch ((int)$code) {
            case 90:
            case 91:
                return Html::img('/img/operators/beeline.jpg', ['class' => 'img-responsive', 'style' => 'max-width: 30px; display: inline-block;']);
            case 93:
            case 94:
                return Html::img('/img/operators/ucell.jpg', ['class' => 'img-responsive', 'style' => 'max-width: 30px; display: inline-block;']);
            case 95:
            case 99:
                return Html::img('/img/operators/uzmobile.jpg', ['class' => 'img-responsive', 'style' => 'max-width: 30px; display: inline-block;']);
            case 97:
                return Html::img('/img/operators/ums.jpg', ['class' => 'img-responsive', 'style' => 'max-width: 30px; display: inline-block;']);
            default:
                return null;
        }
    }

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
                return Html::tag('p', Html::tag('i', null, ['class' => 'ion ion-android-person']) . $name);
            case 'driver':
                return Html::tag('p', Html::tag('i', null, ['class' => 'ion ion-android-car']) . $name);
            case 'dispatcher':
                return Html::tag('p', Html::tag('i', null, ['class' => 'ion ion-android-contact']) . $name);
            case 'administrator':
                return Html::tag('p', Html::tag('i', null, ['class' => 'ion ion-android-contact']) . $name);
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
            case User::STATUS_BUSY:
                return Html::tag('i', 'Занят', ['class' => 'label label-danger']);
            default:
                return Html::tag('i', 'Неизвестный', ['class' => 'label label-default']);
        }
    }

    public static function getStatusText($status)
    {
        switch ($status) {
            case User::STATUS_DELETED:
                return 'Удален';
            case User::STATUS_BLOCKED:
                return 'Заблокирован';
            case User::STATUS_ACTIVE:
                return 'Активный';
            case User::STATUS_BUSY:
                return 'Занят';
            default:
                return 'Неизвестный';
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
            User::STATUS_BUSY => 'Занятые',
        ];
    }

    public static function serializeStatuses()
    {
        return [
            [
                [
                    'code' => User::STATUS_DELETED,
                    'text' => self::getStatusText(User::STATUS_DELETED)
                ],
                [
                    'code' => User::STATUS_BLOCKED,
                    'text' => self::getStatusText(User::STATUS_BLOCKED)
                ],
                [
                    'code' => User::STATUS_ACTIVE,
                    'text' => self::getStatusText(User::STATUS_ACTIVE)
                ],
                [
                    'code' => User::STATUS_BUSY,
                    'text' => self::getStatusText(User::STATUS_BUSY)
                ],
            ]
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
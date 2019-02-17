<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use uztelecom\entities\user\User;
use yii\helpers\Html;

class UserHelper
{
    public static function getName($user): string
    {
        /** @var $user User */
        return $user->username;
    }

    public static function getRoleName($role)
    {
        switch ($role) {
            case 'user':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-street-view']) . ' Пользователь');
            case 'driver':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-car']) . ' Водитель');
            case 'admin':
                return Html::tag('p', Html::tag('i', null, ['class' => 'fa fa-user']) . ' Диспечер');
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
        return [
            'user' => 'Пользователь',
            'driver' => 'Водитель',
            'admin' => 'Диспечер',
        ];
    }

    public static function getStatusList()
    {
        return [
            User::STATUS_DELETED => 'Удалённые',
            User::STATUS_BLOCKED => 'Заблокированные',
            User::STATUS_ACTIVE => 'Активные',
        ];
    }
}
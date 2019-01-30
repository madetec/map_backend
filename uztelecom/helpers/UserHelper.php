<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use uztelecom\entities\user\User;

class UserHelper
{
    public static function getName($user): string
    {
        /** @var $user User */
        return $user->username;
    }
}
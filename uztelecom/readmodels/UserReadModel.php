<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 01.02.2019
 * Time: 22:46
 */

namespace uztelecom\readmodels;
use uztelecom\entities\user\User;

use uztelecom\exceptions\NotFoundException;
use yii\base\Model;

class UserReadModel
{
    public static function find(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundException('User not found.');
        }

        return $user;
    }

}
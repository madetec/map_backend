<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;

use uztelecom\entities\user\User;
use yii\base\Component;

/**
 * @property $allDriverCount
 * @property $allUsersCount
 */
class UserReadRepository extends Component
{
    public function getAllDriverCount()
    {
        return User::find()->driver()->count();
    }

    public function getAllUsersCount()
    {
        return User::find()->user()->count();
    }

    public function find($id): ?User
    {
        return User::findOne($id);
    }

    public function findActiveByUsername($username): ?User
    {
        return User::findOne(['username' => $username, 'status' => [User::STATUS_ACTIVE, User::STATUS_BUSY]]);
    }

    public function findActiveById($id): ?User
    {
        return User::findOne(['id' => $id, 'status' => [User::STATUS_ACTIVE, User::STATUS_BUSY]]);
    }
}

<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\repositories;

use uztelecom\entities\user\Device;
use uztelecom\entities\user\User;
use uztelecom\exceptions\NotFoundException;

class UserRepository
{

    public function findUserByDevice($uid): ?User
    {
        $query = User::find()->alias('u');
        $query->innerJoin(Device::tableName() . ' d', 'd.user_id = u.id');
        $query->where(['d.uid' => $uid]);
        $query->one();
        return $query;
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundException
     */
    public function findRoleDriver($id): User
    {
        if (!$user = User::find()->where(['id' => $id])->driver()->one()) {
            throw new NotFoundException('User not found.');
        }

        return $user;
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundException
     */
    public function findRoleUser($id): User
    {
        if (!$user = User::find()->where(['id' => $id])->user()->one()) {
            throw new NotFoundException('User not found.');
        }

        return $user;
    }

    public function findAllFreeDrivers()
    {
        return User::find()
            ->where(['status' => User::STATUS_ACTIVE])
            ->driver()
            ->all();
    }

    public function count()
    {
        return User::find()->count();
    }

    /**
     * @param string $username
     * @return null|User
     * @throws NotFoundException
     */
    public function findByUsername(string $username)
    {
        if (!$user = User::findOne(['username' => $username])) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }

    /**
     * @param $id
     * @return User
     * @throws NotFoundException
     */
    public function find(int $id): User
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundException('User not found.');
        }

        return $user;
    }

    /**
     * @param User $user
     * @throws \DomainException
     */
    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \DomainException('User save error');
        }
    }

    /**
     * @param User $user
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(User $user): void
    {
        if (!$user->delete()) {
            throw new \DomainException('User remove error');
        }
    }
}
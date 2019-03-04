<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities\user\queries;


use uztelecom\entities\user\User;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => User::STATUS_ACTIVE,
        ]);
    }

    public function delete($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => User::STATUS_DELETED,
        ]);
    }

    public function blocked($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => User::STATUS_BLOCKED,
        ]);
    }

    public function user($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'role' => 'user',
        ]);
    }

    public function driver($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'role' => 'driver',
        ]);
    }

    public function dispatcher($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'role' => 'dispatcher',
        ]);
    }

    public function administrator($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'role' => 'administrator',
        ]);
    }
}
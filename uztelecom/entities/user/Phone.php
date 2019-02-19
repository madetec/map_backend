<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 20:34
 */

namespace uztelecom\entities\user;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
<<<<<<< HEAD
 * Class Phone
 * @package uztelecom\entities\user
 * @property string $number
 */
class Phone extends ActiveRecord
{
    public static function create($number)
    {
        $phone = new static();
        $phone->number = $number;

        return $phone;
    }

    public static function tableName()
=======
 * @property integer $id
 * @property integer $number
 * @property integer $sort
 * @property integer $profile_id
 */
class Phone extends ActiveRecord
{
    public static function create(int $number): self
    {
        $phone = new static();
        $phone->number = $number;
        return $phone;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName(): string
>>>>>>> cafbe82cc8e1bbdbca2472c0c9b13d404442ed2e
    {
        return '{{%phones}}';
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

}
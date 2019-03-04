<?php

namespace uztelecom\entities\cars;

use uztelecom\entities\Color;
use uztelecom\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string $model
 * @property int $color_id
 * @property string $number
 * @property int $user_id
 *
 * @property User $user
 * @property Color $color
 */
class Car extends ActiveRecord
{

    public static function create(string $model, int $color_id, string $number, int $user_id): self
    {
        $car = new static();
        $car->model = $model;
        $car->color_id = $color_id;
        $car->number = $number;
        $car->user_id = $user_id;
        return $car;
    }

    public function edit(string $model, int $color_id, string $number, int $user_id): void
    {
        $this->model = $model;
        $this->color_id = $color_id;
        $this->number = $number;
        $this->user_id = $user_id;
    }

    public static function tableName(): string
    {
        return '{{%cars}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'model' => 'Модель',
            'color_id' => 'Цвет',
            'number' => 'Номер',
            'user_id' => 'Водитель',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getColor(): ActiveQuery
    {
        return $this->hasOne(Color::class, ['id' => 'color_id']);
    }

}

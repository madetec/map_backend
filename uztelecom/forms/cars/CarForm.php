<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\forms\cars;

use uztelecom\entities\cars\Car;
use uztelecom\entities\Color;
use uztelecom\entities\user\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CarForm
 * @package uztelecom\forms\cars
 * @property  string $model
 * @property  string $color_id
 * @property  string $number
 * @property  integer $user_id
 * @property  array drivers
 * @property  array colors
 * @property  Car $_car
 */
class CarForm extends Model
{
    public $model;
    public $color_id;
    public $number;
    public $user_id;

    private $_car;

    public function __construct(Car $car = null, array $config = [])
    {
        if ($car) {
            $this->model = $car->model;
            $this->color_id = $car->color_id;
            $this->number = $car->number;
            $this->user_id = $car->user_id;
            $this->_car = $car;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['model', 'number', 'user_id', 'color_id'], 'required'],
            [['user_id', 'color_id'], 'integer'],
            [['model', 'number'], 'string', 'max' => 255],
            [['number'], 'unique', 'targetClass' => Car::class, 'filter' => $this->_car ? ['<>', 'id', $this->_car->id] : null],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['color_id' => 'id']],
        ];
    }

    public function getColors()
    {
        return ArrayHelper::map(Color::find()->orderBy(['name' => SORT_ASC])->asArray()->all(), 'id', 'name');
    }

    public function getDrivers()
    {
        return ArrayHelper::map(User::find()->active()->driver()->all(), 'id', function (User $user) {
            return $user->profile->getFullName();
        });
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Модель',
            'color_id' => 'Цвет',
            'number' => 'Номер',
            'user_id' => 'Водитель',
        ];
    }
}
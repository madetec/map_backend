<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use uztelecom\entities\user\Phone;
use yii\base\Model;

/**
 * @property ProfileForm $profile
 * @property integer $number
 */
class PhoneForm extends Model
{
    public $number;
    private $_phone;

    public function __construct(Phone $phone = null, array $config = [])
    {
        if ($phone) {
            $this->number = $phone->number;
            $this->_phone = $phone;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['number', 'required'],
            ['number', 'integer'],
            [['number'],
                'unique',
                'targetClass' => Phone::class,
                'filter' => $this->_phone ? ['<>', 'id', $this->_phone->id] : null],
        ];
    }

    public function beforeValidate()
    {
        if ($this->number) {
            $this->number = str_replace(['+998', '(', ')', ' '], '', $this->number);
        }
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'number' => 'Номер телефона',
        ];
    }

}
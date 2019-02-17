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
 *
 */
class PhoneForm extends Model
{
    public $number;

    public function __construct(Phone $phone = null, array $config = [])
    {
        if ($phone) {
            $this->number = $phone;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['number', 'required'],
            ['number', 'integer'],
        ];
    }

}
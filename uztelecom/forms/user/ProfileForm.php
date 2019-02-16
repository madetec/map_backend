<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use uztelecom\entities\Subdivision;
use uztelecom\entities\user\Profile;
use uztelecom\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * @property PhoneForm $phone
 * @property AddressForm $address
 */
class ProfileForm extends CompositeForm
{
    public $name;
    public $last_name;
    public $father_name;
    public $subdivision_id;
    public $position;

    public function __construct(Profile $profile = null, array $config = [])
    {
        if ($profile) {
            $this->name = $profile->name;
            $this->last_name = $profile->last_name;
            $this->father_name = $profile->father_name;
            $this->subdivision_id = $profile->subdivision_id;
            $this->position = $profile->position;
        }

        $this->phone = new PhoneForm();
        $this->address = new AddressForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'last_name', 'subdivision_id', 'position'], 'required'],
            [['name', 'last_name', 'father_name',  'position'], 'string'],
            ['subdivision_id', 'integer'],

        ];
    }

    protected function internalForms(): array
    {
        return ['phone','address'];
    }

    public function subdivisionList()
    {
        return ArrayHelper::map(Subdivision::find()->asArray()->all(), 'id', 'name');
    }


    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'father_name' => 'Отчество',
            'subdivision_id' => 'Подразделение',
            'position' => 'Должность',
        ];
    }

}
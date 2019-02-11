<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use uztelecom\entities\user\Profile;
use uztelecom\forms\CompositeForm;

/**
 * @property PhoneForm $phone
 * @property AddressForm $address
 */
class ProfileForm extends CompositeForm
{
    public $name;
    public $last_name;
    public $father_name;
    public $subdivision;
    public $position;

    public function __construct(Profile $profile = null, array $config = [])
    {
        if ($profile) {
            $this->name = $profile->name;
            $this->last_name = $profile->last_name;
            $this->father_name = $profile->father_name;
            $this->subdivision = $profile->subdivision;
            $this->position = $profile->position;
        }
        $this->phone = new PhoneForm();
        $this->address = new AddressForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [
                ['name', 'last_name', 'subdivision', 'position'], 'required'
            ],
            [
                ['name', 'last_name', 'father_name', 'subdivision', 'position'], 'string'
            ],

        ];
    }

    protected function internalForms(): array
    {
        return ['phone','address'];
    }

}
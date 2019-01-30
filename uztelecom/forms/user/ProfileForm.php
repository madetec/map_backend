<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 21:48
 */

namespace uztelecom\forms\user;


use uztelecom\forms\CompositeForm;

class ProfileForm extends CompositeForm
{
    public $name;
    public $last_name;
    public $father_name;
    public $subdivision;
    public $position;

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
        return [];
    }

}
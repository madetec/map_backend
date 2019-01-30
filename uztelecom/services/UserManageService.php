<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 22:17
 */

namespace uztelecom\services;


use uztelecom\entities\user\User;
use uztelecom\forms\user\UserForm;
use uztelecom\repositories\UserRepository;

class UserManageService
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }


    public function create(UserForm $form): User
    {

    }
}
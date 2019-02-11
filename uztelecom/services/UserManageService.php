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

    /**
     * @param UserForm $form
     * @return User
     * @throws \DomainException
     */
    public function create(UserForm $form): User
    {
        $user = User::create($form->username, $form->password, $form->profile);
        $this->users->save($user);
        return $user;
    }


}
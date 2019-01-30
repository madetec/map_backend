<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 22:17
 */

namespace uztelecom\services;


use uztelecom\entities\user\Profile;
use uztelecom\entities\user\User;
use uztelecom\forms\user\UserForm;
use uztelecom\repositories\UserRepository;
use yii\helpers\VarDumper;

class UserManageService
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }


    public function create(UserForm $form): User
    {
        $user = User::create($form->username);
        $user->setPassword($form->password);
        $user->generateAuthKey();

        $profile = Profile::create(
            $form->profile->name,
            $form->profile->last_name,
            $form->profile->father_name,
            $form->profile->subdivision,
            $form->profile->position);

        $user->profile = $profile;

        $this->users->save($user);

        VarDumper::dump($user,10,true);die;

    }
}
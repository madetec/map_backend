<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\services;

use uztelecom\entities\user\User;
use uztelecom\forms\auth\SignInForm;
use uztelecom\forms\auth\SignUpForm;
use uztelecom\repositories\UserRepository;
use Yii;

/** @property UserRepository $users */
class AuthService
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }


    /**
     * @param SignInForm $form
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function signIn(SignInForm $form): void
    {
        $user = $this->users->findByUsername($form->username);
        $duration = $form->rememberMe ? $user::REMEMBER_ME_DURATION : 0;
        if (!Yii::$app->user->login($user, $duration)) {
            throw new \DomainException('Login error');
        }
    }

    /**
     * @param SignUpForm $form
     * @throws \DomainException
     */
    public function signUp(SignUpForm $form)
    {
        $user  = User::signUp($form->username);
        $user->setPassword($form->password);
        $user->generateAuthKey();
        $this->users->save($user);
    }


    public function isFirstUser(): bool
    {
        return !$this->users->count() ? true : false;
    }
}
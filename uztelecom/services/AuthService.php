<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\services;

use common\auth\Identity;
use common\components\AuthManager;
use uztelecom\entities\user\User;
use uztelecom\forms\auth\SignInForm;
use uztelecom\forms\auth\SignUpForm;
use uztelecom\repositories\UserRepository;
use Yii;
use yii\web\ForbiddenHttpException;

/**
 * @property UserRepository $users
 * @property AuthManager $authManager
 */
class AuthService
{
    private $users;
    private $authManager;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
        $this->authManager = Yii::$app->getAuthManager();
    }


    /**
     * @param SignInForm $form
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws ForbiddenHttpException
     */
    public function signIn(SignInForm $form): void
    {
        $user = $this->users->findByUsername($form->username);
        $duration = $form->rememberMe ? $user::REMEMBER_ME_DURATION : 0;

        if (!Yii::$app->user->login(new Identity($user), $duration)) {
            throw new \DomainException('Sign in error');
        }

        if (!Yii::$app->user->can('administrator')) {
            Yii::$app->user->logout();
            throw new ForbiddenHttpException('Access is denied!');
        }
    }

    /**
     * @param SignUpForm $form
     * @throws \DomainException
     * @throws \Exception
     */
    public function signUp(SignUpForm $form)
    {
        $user = User::signUp($form->username, $form->name, $form->last_name, $form->subdivision_id, $form->position);
        $user->setPassword($form->password);
        $user->generateAuthKey();
        $this->users->save($user);
        $role = $this->authManager->getRole('administrator');
        $this->authManager->assign($role, $user->id);
    }


    public function isFirstUser(): bool
    {
        return !$this->users->count() ? true : false;
    }
}
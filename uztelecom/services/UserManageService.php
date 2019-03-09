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
use uztelecom\forms\user\AddressForm;
use uztelecom\forms\user\PhoneForm;
use uztelecom\forms\user\UserEditForm;
use uztelecom\forms\user\UserForm;
use uztelecom\repositories\UserRepository;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class UserManageService
 * @package uztelecom\services
 * @property  UserRepository $users
 */
class UserManageService
{
    private $users;
    private $auth;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
        $this->auth = \Yii::$app->getAuthManager();
    }

    /**
     * @param UserForm $form
     * @return User
     * @throws \DomainException
     * @throws \LogicException
     */
    public function create(UserForm $form): User
    {
        $user = User::create($form->username, $form->password, $form->profile);
        $user->profile->addPhone($form->profile->phone->number);
        $user->profile->addAddress($form->profile->address->name);
        $this->users->save($user);
        $role = $this->auth->getRole($form->role);
        $this->auth->assign($role, $user->id);
        return $user;
    }

    /**
     * @param User $user
     * @param UserEditForm $form
     * @throws \DomainException
     * @throws \yii\base\Exception
     */
    public function edit(User $user, UserEditForm $form): void
    {
        $user->edit($form->password, $form->profile);
        $this->users->save($user);
        $role = $this->auth->getRole($form->role);
        $this->auth->assign($role, $user->id);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function remove($id)
    {
        $user = $this->users->find($id);
        $user->status = User::STATUS_DELETED;
        $this->users->save($user);
    }

    /**
     * @param $id
     * @param PhoneForm $form
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function addPhone($id, PhoneForm $form): void
    {
        $user = $this->users->find($id);
        $profile = $user->profile;
        $profile->addPhone($form->number);
        $user->updateProfile($profile);
        $this->users->save($user);
    }

    /**
     * @param $id
     * @param $phoneId
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function movePhoneUp($id, $phoneId): void
    {
        $user = $this->users->find($id);
        $profile = $user->profile;
        $profile->movePhoneUp($phoneId);
        $user->updateProfile($profile);
        $this->users->save($user);
    }

    /**
     * @param $id
     * @param $phoneId
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function movePhoneDown($id, $phoneId): void
    {
        $user = $this->users->find($id);
        $profile = $user->profile;
        $profile->movePhoneDown($phoneId);
        $user->updateProfile($profile);
        $this->users->save($user);
    }

    /**
     * @param $id
     * @param $phoneId
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function removePhone($id, $phoneId): void
    {
        $user = $this->users->find($id);
        $profile = $user->profile;
        $profile->removeRelation(Profile::TYPE_PHONES, $phoneId);
        $user->updateProfile($profile);
        $this->users->save($user);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function busy($id)
    {
        $user = $this->users->find($id);
        $user->busy();
        $this->users->save($user);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function active($id)
    {
        $user = $this->users->find($id);
        $user->active();
        $this->users->save($user);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function blocked($id)
    {
        $user = $this->users->find($id);
        $user->blocked();
        $this->users->save($user);
    }

    /**
     * @param $id
     * @param AddressForm $form
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function addAddress($id, AddressForm $form)
    {
        $user = $this->users->find($id);
        $profile = $user->profile;
        $profile->addAddress($form->name, $form->lat, $form->lng);
        $user->updateProfile($profile);
        $this->users->save($user);
    }


}
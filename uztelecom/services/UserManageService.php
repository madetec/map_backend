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

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
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
        return $user;
    }

    /**
     * @param User $user
     * @param UserForm $form
     * @throws \DomainException
     * @throws \yii\base\Exception
     */
    public function edit(User $user, UserForm $form): void
    {
        $user->edit($form->username, $form->password, $form->profile);
        $this->users->save($user);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \Throwable
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id)
    {
        $user = $this->users->find($id);
        $user->status = User::STATUS_DELETED;
        $this->users->save($user);
    }

    /**
     * @param $id
     * @param $phoneId
     * @throws \DomainException
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


}
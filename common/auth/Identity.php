<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace common\auth;

use filsh\yii2\oauth2server\Module;
use OAuth2\Storage\RefreshTokenInterface;
use OAuth2\Storage\UserCredentialsInterface;
use uztelecom\entities\user\User;
use uztelecom\readModels\UserReadRepository;
use Yii;
use yii\web\IdentityInterface;

class Identity implements IdentityInterface, UserCredentialsInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param int|string $id
     * @return Identity|null|IdentityInterface
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public static function findIdentity($id)
    {
        $user = self::getRepository()->findActiveById($id);
        return $user ? new self($user) : null;
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return Identity|null|IdentityInterface
     * @throws \yii\base\InvalidConfigException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = self::getOauth()->getServer()->getResourceController()->getToken();
        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getUsername()
    {
        return $this->user->username;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     * @throws \yii\base\InvalidArgumentException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function checkUserCredentials($username, $password): bool
    {
        if (!$user = self::getRepository()->findActiveByUsername($username)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    /**
     * @param string $username
     * @return array
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getUserDetails($username): array
    {
        $user = self::getRepository()->findActiveByUsername($username);
        return [
            'user_id' => $user->id,
            'fullName' => $user->profile->fullName,
            'role' => $user->role,
        ];
    }

    /**
     * @return UserReadRepository
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    private static function getRepository(): UserReadRepository
    {
        return \Yii::$container->get(UserReadRepository::class);
    }

    private static function getOauth(): Module
    {
        return Yii::$app->getModule('oauth2');
    }


//    public function getRefreshToken($refresh_token)
//    {
//        $data = self::getOauth()->getServer()->getResourceController()->getToken();
//        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
//    }
//
//    public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = null)
//    {
//
//    }
//
//    public function unsetRefreshToken($refresh_token)
//    {
//
//    }
}
<?php

namespace uztelecom\entities\user;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use uztelecom\constants\Status;
use uztelecom\entities\cars\Car;
use uztelecom\entities\user\queries\UserQuery;
use uztelecom\forms\user\ProfileEditForm;
use uztelecom\forms\user\ProfileForm;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property Profile $profile
 * @property Car $car
 * @property array $roleName
 */
class User extends ActiveRecord implements Status
{

    const REMEMBER_ME_DURATION = 3600 * 24 * 30;

    public static function create($username, $password, ProfileForm $profile)
    {
        $user = new static();
        $user->username = $username;
        $user->profile = Profile::create(
            $profile->name,
            $profile->last_name,
            $profile->father_name,
            $profile->subdivision_id,
            $profile->position
        );
        $user->setPassword($password);
        $user->generateAuthKey();
        return $user;
    }

    /**
     * @param $password
     * @param ProfileEditForm $profileForm
     * @throws \yii\base\Exception
     */

    public function edit($password, ProfileEditForm $profileForm): void
    {
        if ($password) {
            $this->setPassword($password);
        }
        $profile = $this->profile;
        $profile->edit(
            $profileForm->name,
            $profileForm->last_name,
            $profileForm->father_name,
            $profileForm->subdivision_id,
            $profileForm->position
        );
        $this->updateProfile($profile);
    }

    public function updateProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }

    public static function signUp($username, $name, $last_name, $subdivision_id, $position)
    {
        $user = new static();
        $user->username = $username;
        $user->status = self::STATUS_ACTIVE;
        $user->profile = Profile::create($name, $last_name, null, $subdivision_id, $position);
        return $user;
    }

    /**
     * @throws \DomainException
     */
    public function blocked(): void
    {
        if ($this->isBlocked()) {
            throw new \DomainException('User status is blocked');
        }
        $this->status = self::STATUS_BLOCKED;
    }

    public function isBlocked(): bool
    {
        return $this->status === self::STATUS_BLOCKED;
    }

    /**
     * @throws \DomainException
     */
    public function active(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('User status is active');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @throws \DomainException
     */
    public function busy(): void
    {
        if ($this->isBusy()) {
            throw new \DomainException('User status is busy');
        }
        $this->status = self::STATUS_BUSY;
    }

    public function isBusy(): bool
    {
        return $this->status === self::STATUS_BUSY;
    }


    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
    }

    public function getCar(): ActiveQuery
    {
        return $this->hasOne(Car::class, ['user_id' => 'id']);
    }


    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['profile']
            ]
        ];
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @param $password
     * @return bool
     * @throws \yii\base\InvalidArgumentException
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'status' => 'Состояние',
            'role' => 'Роль',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'fullName' => 'Ф.И.О',
            'subdivision' => 'Подрозделение',
        ];
    }

    public static function find(): UserQuery
    {
        return new UserQuery(static::class);
    }
}

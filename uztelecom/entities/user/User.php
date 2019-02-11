<?php

namespace uztelecom\entities\user;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
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
 */
class User extends ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_BLOCKED = 5;
    const STATUS_ACTIVE = 10;

    const REMEMBER_ME_DURATION = 3600 * 24 * 30;


    public static function create($username, $password, ProfileForm $profile)
    {
        $user = new static();
        $user->username = $username;
        $user->profile = Profile::create(
            $profile->name,
            $profile->last_name,
            $profile->father_name,
            $profile->subdivision,
            $profile->position);
        $user->setPassword($password);
        $user->generateAuthKey();
        return $user;
    }

    /**
     * @param $username
     * @param $password
     * @param ProfileForm $profile
     * @throws \yii\base\Exception
     */

    public function edit($username, $password, ProfileForm $profile): void
    {
        $this->username = $username;
        $this->setPassword($password);
        $this->updateProfile($profile);

    }


    private function updateProfile(ProfileForm $form)
    {
        $profile = $this->profile;
        $profile->edit(
            $form->name,
            $form->last_name,
            $form->father_name,
            $form->subdivision,
            $form->position
        );
        $this->profile = $profile;
    }

    public static function signUp($username)
    {
        $user = new static();
        $user->username = $username;
        $user->status = self::STATUS_ACTIVE;
        return $user;
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id']);
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
}

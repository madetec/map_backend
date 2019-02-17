<?php


namespace uztelecom\entities\user;


use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use uztelecom\entities\Subdivision;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 30.01.2019
 * Time: 20:25
 * @property string $name
 * @property string $last_name
 * @property string $father_name
 * @property integer $subdivision_id
 * @property string $position
 * @property integer $main_phone_id
 * @property integer $main_address_id
 * @property User $user
 * @property Phone[] $phones
 * @property Address[] $addresses
 * @property string $fullName
 *
 * @property Subdivision $subdivision
 *
 */
class Profile extends ActiveRecord
{
    public static function create($name, $last_name, $father_name, $subdivision_id, $position)
    {
        $profile = new static();
        $profile->name = $name;
        $profile->last_name = $last_name;
        $profile->father_name = $father_name;
        $profile->subdivision_id = $subdivision_id;
        $profile->position = $position;
        $profile->phones = $phone;

        return $profile;

    }

    public function edit($name, $last_name, $father_name, $subdivision_id, $position)
    {
        $this->name = $name;
        $this->last_name = $last_name;
        $this->father_name = $father_name;
        $this->subdivision_id = $subdivision_id;
        $this->position = $position;
    }

    public function isMainPhone(int $phoneId): bool
    {
        return $this->main_phone_id == $phoneId;
    }

    public function addPhone(int $number): void
    {
        $phones = $this->phones;
        $phones[] = Phone::create($number);
        $this->updatePhones($phones);
    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function removePhone($id): void
    {
        $phones = $this->phones;
        foreach ($phones as $i => $phone) {
            if ($phone->isIdEqualTo($id)) {
                unset($phones[$i]);
                $this->updatePhones($phones);
                return;
            }
        }
        throw new \DomainException('Phone is not found.');
    }

    public function removePhones(): void
    {
        $this->updatePhones([]);
    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function movePhoneUp($id): void
    {
        $phones = $this->phones;
        foreach ($phones as $i => $phone) {
            if ($phone->isIdEqualTo($id)) {
                if ($prev = $phones[$i - 1] ?? null) {
                    $phones[$i - 1] = $phone;
                    $phones[$i] = $prev;
                    $this->updatePhones($phones);
                }
                return;
            }
        }
        throw new \DomainException('Phone is not found.');
    }

    /**
     * @param $id
     * @throws \DomainException
     */
    public function movePhoneDown($id): void
    {
        $phones = $this->phones;
        foreach ($phones as $i => $phone) {
            if ($phone->isIdEqualTo($id)) {
                if ($next = $phones[$i + 1] ?? null) {
                    $phones[$i] = $next;
                    $phones[$i + 1] = $phone;
                    $this->updatePhones($phones);
                }
                return;
            }
        }
        throw new \DomainException('Phone is not found.');
    }

    private function updatePhones(array $phones): void
    {
        /* @var Phone[] $phones */
        foreach ($phones as $i => $phone) {
            $phone->setSort($i);
        }

        $this->phones = $phones;
        $this->populateRelation('mainPhone', reset($phones));
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete(): bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->phones as $phone) {
                $phone->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);
        if (array_key_exists('mainPhone', $related)) {
            $this->updateAttributes(['main_phone_id' => $related['mainPhone'] ? $related['mainPhone']->id : null]);
        }
    }

    public function getSubdivision(): ActiveQuery
    {
        return $this->hasOne(Subdivision::class, ['id' => 'subdivision_id']);
    }

    public function getFullName()
    {
        $fullName = $this->last_name . ' ' . $this->name;
        $fullName = $this->father_name ? $fullName . ' ' . $this->father_name : $fullName;
        return $fullName;
    }

    public static function tableName()
    {

        return '{{%profiles}}';
    }

    public function getUser(): ActiveQuery
    {

        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPhones(): ActiveQuery
    {
        return $this->hasMany(Phone::class, ['profile_id' => 'id'])->orderBy('sort');
    }

    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(Address::class, ['profile_id' => 'id']);
    }


    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['phones', 'addresses']
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'father_name' => 'Отчество',
            'subdivision' => 'Подрозделение',
            'position' => 'Должность',
        ];
    }


}
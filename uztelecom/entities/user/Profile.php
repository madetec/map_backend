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
 * @property Phone $mainPhone
 * @property Address $mainAddress
 *
 * @property Subdivision $subdivision
 *
 */
class Profile extends ActiveRecord
{

    const TYPE_PHONES = 5;
    const TYPE_ADDRESSES = 10;

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

    public function isMainAddress(int $addressId): bool
    {
        return $this->main_address_id == $addressId;
    }

    /**
     * @param int $number
     * @throws \LogicException
     */
    public function addPhone(int $number): void
    {
        $phones = $this->phones;
        $phones[] = Phone::create($number);
        $this->updateRelations(self::TYPE_PHONES, $phones);
    }

    /**
     * @param string $name
     * @throws \LogicException
     */
    public function addAddress(string $name): void
    {
        $addresses = $this->addresses;
        $addresses[] = Address::create($name);
        $this->updateRelations(self::TYPE_ADDRESSES, $addresses);
    }

    /**
     * @param $type
     * @param $relationId
     * @throws \DomainException
     * @throws \LogicException
     */
    public function removeRelation($type, $relationId): void
    {
        switch ($type) {
            case self::TYPE_PHONES:
                $items = $this->phones;
                $relationName = 'Phone';
                break;
            case self::TYPE_ADDRESSES:
                $items = $this->addresses;
                $relationName = 'Address';
                break;
            default:
                throw new \LogicException('removeRelation() incorrect type');
        }

        foreach ($items as $i => $item) {
            if ($item->isIdEqualTo($relationId)) {
                unset($items[$i]);
                $this->updateRelations($type, $items);
                return;
            }
        }
        throw new \DomainException($relationName . ' is not found.');
    }

    /**
     * @throws \LogicException
     */
    public function removePhones(): void
    {
        $this->updateRelations(self::TYPE_PHONES, []);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \LogicException
     */
    public function movePhoneUp($id): void
    {
        $phones = $this->phones;
        foreach ($phones as $i => $phone) {
            if ($phone->isIdEqualTo($id)) {
                if ($prev = $phones[$i - 1] ?? null) {
                    $phones[$i - 1] = $phone;
                    $phones[$i] = $prev;
                    $this->updateRelations(self::TYPE_PHONES, $phones);
                }
                return;
            }
        }
        throw new \DomainException('Phone is not found.');
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \LogicException
     */
    public function movePhoneDown($id): void
    {
        $phones = $this->phones;
        foreach ($phones as $i => $phone) {
            if ($phone->isIdEqualTo($id)) {
                if ($next = $phones[$i + 1] ?? null) {
                    $phones[$i] = $next;
                    $phones[$i + 1] = $phone;
                    $this->updateRelations(self::TYPE_PHONES, $phones);
                }
                return;
            }
        }
        throw new \DomainException('Phone is not found.');
    }

    /**
     * @param $type
     * @param array $items
     * @throws \LogicException
     */
    private function updateRelations($type, array $items): void
    {
        /* @var Phone[]|Address[] $items */
        switch ($type) {
            case self::TYPE_PHONES:
                $populateRelationName = 'mainPhone';
                $relationName = 'phones';
                break;
            case self::TYPE_ADDRESSES:
                $populateRelationName = 'mainAddress';
                $relationName = 'addresses';
                break;
            default:
                throw new \LogicException('updateRelations() incorrect type');
        }
        foreach ($items as $i => $item) {
            $item->setSort($i);
        }
        $this->{$relationName} = $items;
        $this->populateRelation($populateRelationName, reset($items));
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
            foreach ($this->addresses as $address) {
                $address->delete();
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
        if (array_key_exists('mainAddress', $related)) {
            $this->updateAttributes(['main_address_id' => $related['mainAddress'] ? $related['mainAddress']->id : null]);
        }
    }

    public function getFullName()
    {
        $fullName = $this->last_name . ' ' . $this->name;
        $fullName = $this->father_name ? $fullName . ' ' . $this->father_name : $fullName;
        return $fullName;
    }

    // user
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // subdivision
    public function getSubdivision(): ActiveQuery
    {
        return $this->hasOne(Subdivision::class, ['id' => 'subdivision_id']);
    }

    // phones
    public function getPhones(): ActiveQuery
    {
        return $this->hasMany(Phone::class, ['profile_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhone(): ActiveQuery
    {
        return $this->hasOne(Phone::class, ['id' => 'main_phone_id']);
    }

    // addresses
    public function getAddresses(): ActiveQuery
    {
        return $this->hasMany(Address::class, ['profile_id' => 'id']);
    }

    public function getMainAddress(): ActiveQuery
    {
        return $this->hasOne(Address::class, ['id' => 'main_address_id']);
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

    public static function tableName()
    {
        return '{{%profiles}}';
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
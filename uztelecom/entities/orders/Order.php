<?php

namespace uztelecom\entities\orders;

use uztelecom\entities\user\User;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property int $status
 * @property double $from_lat
 * @property double $from_lng
 * @property string $from_address
 * @property double $to_lat
 * @property double $to_lng
 * @property string $to_address
 * @property int $created_at
 * @property int $created_by
 * @property int $completed_at
 * @property int $driver_id
 *
 * @property User $user
 * @property User $driver
 */
class Order extends ActiveRecord
{
    const STATUS_ACTIVE = 5;
    const STATUS_BUSY = 10;
    const STATUS_CANCELED = 15;
    const STATUS_COMPLETED = 20;
    const STATUS_WAIT = 25;

    public static function create(
        int $created_by,
        float $from_lat,
        float $from_lng,
        string $from_address,
        float $to_lat = null,
        float $to_lng = null,
        string $to_address = null): self
    {
        $order = new static();
        $order->created_by = $created_by;
        $order->from_lat = $from_lat;
        $order->from_lng = $from_lng;
        $order->from_address = $from_address;
        $order->to_lat = $to_lat;
        $order->to_lng = $to_lng;
        $order->to_address = $to_address;
        $order->created_at = time();
        $order->status = self::STATUS_ACTIVE;
        return $order;
    }

    public function takeOrder($driver_id)
    {
        $this->status = self::STATUS_BUSY;
        $this->driver_id = $driver_id;
    }

    /**
     * @throws \DomainException
     */
    public function completed()
    {
        if ($this->isCompleted()) {
            throw new \DomainException('this order status is completed.');
        }
        $this->completed_at = time();
        $this->status = self::STATUS_COMPLETED;
    }

    /**
     * @throws \DomainException
     */
    public function canceled()
    {
        if ($this->isCanceled()) {
            throw new \DomainException('this order status is canceled.');
        }
        $this->completed_at = time();
        $this->status = self::STATUS_CANCELED;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isCanceled(): bool
    {
        return $this->status === self::STATUS_CANCELED;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'from_lat' => 'From Lat',
            'from_lng' => 'From Lng',
            'from_address' => 'From Address',
            'to_lat' => 'To Lat',
            'to_lng' => 'To Lng',
            'to_address' => 'To Address',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'completed_at' => 'Completed At',
            'driver_id' => 'Driver ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(User::class, ['id' => 'driver_id']);
    }
}

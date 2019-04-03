<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities\notification;

use uztelecom\constants\Status;
use yii\db\ActiveRecord;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class NotificationAssignments
 * @package uztelecom\entities\notification
 * @property integer $to_id
 * @property integer $notification_id
 * @property integer $status
 */

class NotificationAssignments extends ActiveRecord implements Status
{
    public static function create($to_id): self
    {
        $assignment = new static();
        $assignment->to_id = $to_id;
        $assignment->status = self::STATUS_UNREAD;
        return $assignment;
    }

    /**
     * @throws \DomainException
     */
    public function read(): void
    {
        if (!$this->isRead()) {
            $this->status = self::STATUS_READ;
            return;
        }
        throw new \DomainException('status is all ready status read');
    }

    public function isRead(): bool
    {
        return $this->status == self::STATUS_READ;
    }

    public function isForNotificationId($notification_id): bool
    {
        return $this->notification_id == $notification_id;
    }
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\repositories;


use uztelecom\entities\notification\Notification;
use uztelecom\exceptions\NotFoundException;

class NotificationRepository
{

    /**
     * @param $id
     * @throws NotFoundException
     */
    public function find($id)
    {
        if (!$notification = Notification::findOne($id)) {
            throw new NotFoundException('Notification not found.');
        }
    }

    /**
     * @param Notification $notification
     * @throws \DomainException
     */
    public function save(Notification $notification): void
    {
        if (!$notification->save()) {
            throw new \DomainException('Notification Save Error.');
        }
    }
}
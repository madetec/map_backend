<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\components\notification;

use uztelecom\entities\notification\Notification;
use uztelecom\events\notification\NotificationEvent;
use uztelecom\repositories\NotificationRepository;
use uztelecom\repositories\UserRepository;
use yii\base\Component;

class NotificationComponent extends Component
{
    public $notifications;
    public $users;

    public function __construct(
        UserRepository $userRepository,
        NotificationRepository $notificationRepository,
        array $config = []
    )
    {
        $this->users = $userRepository;
        $this->notifications = $notificationRepository;
        parent::__construct($config);
    }

    /**
     * @param NotificationEvent $event
     * @throws \DomainException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function newOrder(NotificationEvent $event)
    {
        $drivers = $this->users->findAllFreeDrivers();
        $notification = Notification::create(
            Notification::TYPE_NEW_ORDER,
            $event->type_id,
            $event->from_id
        );
        foreach ($drivers as $driver) {
            $notification->assign($driver->id);
        }
        $this->notifications->save($notification);

    }
}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\components\notification;

use paragraph1\phpFCM\Recipient\Device;
use understeam\fcm\Client;
use uztelecom\entities\notification\Notification;
use uztelecom\entities\user\User;
use uztelecom\events\notification\NotificationEvent;
use uztelecom\repositories\NotificationRepository;
use uztelecom\repositories\OrderRepository;
use uztelecom\repositories\UserRepository;
use Yii;
use yii\base\Component;

/**
 * Class NotificationComponent
 * @package uztelecom\components\notification
 * @property Client $fcm
 * @property UserRepository $users
 * @property NotificationRepository $notifications
 * @property OrderRepository $orders
 */
class NotificationComponent extends Component
{
    private $notifications;
    private $users;
    private $fcm;
    private $orders;

    public function __construct(
        UserRepository $userRepository,
        NotificationRepository $notificationRepository,
        OrderRepository $orderRepository,
        array $config = []
    )
    {
        $this->users = $userRepository;
        $this->notifications = $notificationRepository;
        $this->orders = $orderRepository;
        $this->fcm = Yii::$app->firebase;
        parent::__construct($config);
    }

    /**
     * @param NotificationEvent $event
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws \yii\base\InvalidParamException
     */
    public function newOrder(NotificationEvent $event)
    {
        $drivers = $this->users->findAllFreeDrivers();
        $notification = Notification::create(
            Notification::TYPE_NEW_ORDER,
            $event->type_id,
            $event->from_id
        );
        $order = $this->orders->find($event->type_id);

        /** @var User[] $drivers */
        foreach ($drivers as $driver) {
            $notification->assign($driver->id);
            foreach ($driver->devices as $device) {
                $this->sendPushNotificationToDevice(
                    'Новый заказ',
                    "От {$order->from_address} до {$order->to_address}\n Заказчик: {$order->user->profile->getFullName()}",
                    $device->firebase_token
                );
            }
        }
        $this->notifications->save($notification);

    }

    /**
     * @param string $title
     * @param string $body
     * @param string $firebase_token
     * @param array|null $data
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \yii\base\InvalidParamException
     */
    private function sendPushNotificationToDevice(string $title, string $body, string $firebase_token, array $data = null)
    {
        $note = $this->fcm->createNotification($title, $body);

        $note->setIcon('icon_round.png')
            ->setColor('#ffffff')
            ->setBadge(1)
            ->setSound('default');

        $message = $this->fcm->createMessage();
        $message->setNotification($note);
        if ($data) {
            $message->setData($data);
        }

        $message->addRecipient(new Device($firebase_token));
        $response = $this->fcm->send($message);
        $response->getStatusCode();
    }
}
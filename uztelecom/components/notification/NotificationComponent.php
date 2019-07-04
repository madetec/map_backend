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
    public function completedOrder(NotificationEvent $event)
    {
        $from = $this->users->find($event->from_id);
        $to = $this->users->find($event->to_id);

        $notification = Notification::create(
            $event->type,
            $event->type_id,
            $event->from_id
        );
        $notification->assign($to->id);
        $order = $this->orders->find($event->type_id);

        $title = "Водитель выполнил заказ!";
        $body = "Машина: {$from->car->model} {$from->car->number}" . PHP_EOL;
        $body .= "Водитель: {$from->profile->getFullName()}" . PHP_EOL;
        foreach ($to->devices as $device) {
            $this->sendPushNotificationToDevice(
                $title,
                $body,
                $device->firebase_token,
                [
                    'id' => $order->id,
                    'type' => 'completed_order',
                    'status' => $order->status,
                ]
            );
        }
        $this->notifications->save($notification);
    }

    /**
     * @param NotificationEvent $event
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws \yii\base\InvalidParamException
     */
    public function cancelOrder(NotificationEvent $event)
    {
        $from = $this->users->find($event->from_id);
        $to = $this->users->find($event->to_id);

        $notification = Notification::create(
            $event->type,
            $event->type_id,
            $event->from_id
        );
        $notification->assign($to->id);
        $order = $this->orders->find($event->type_id);

        if ($from->role === 'user') {
            $title = "Пользователь отменил заказ.";
            $body = $from->car ? "Машина: {$from->car->model} {$from->car->number}" . PHP_EOL : '';
            $body .= "Пользователь: {$from->profile->getFullName()}" . PHP_EOL;
            $who = 'user';
        } else {
            $title = "Водитель отменил заказ.";
            $body = "Машина: {$from->car->model} {$from->car->number}" . PHP_EOL;
            $body .= "Водитель: {$from->profile->getFullName()}" . PHP_EOL;
            $who = 'driver';
        }

        foreach ($to->devices as $device) {
            $this->sendPushNotificationToDevice(
                $title,
                $body,
                $device->firebase_token,
                [
                    'id' => $order->id,
                    'type' => 'cancel_order',
                    'who' => $who,
                    'status' => $order->status,
                ]
            );
        }
        $this->notifications->save($notification);
    }

    /**
     * @param NotificationEvent $event
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws \yii\base\InvalidParamException
     */
    public function takeOrder(NotificationEvent $event)
    {
        $from = $this->users->find($event->from_id);
        $to = $this->users->find($event->to_id);

        $notification = Notification::create(
            $event->type,
            $event->type_id,
            $event->from_id
        );
        $notification->assign($to->id);
        $order = $this->orders->find($event->type_id);

        $title = "Водитель в пути";
        $body = "Машина: {$from->car->model} {$from->car->number}" . PHP_EOL;
        $body .= "Водитель: {$from->profile->getFullName()}" . PHP_EOL;
        foreach ($to->devices as $device) {
            $this->sendPushNotificationToDevice(
                $title,
                $body,
                $device->firebase_token,
                [
                    'id' => $order->id,
                    'type' => 'take_order',
                    'status' => $order->status,
                ]
            );
        }
        $this->notifications->save($notification);
    }

    /**
     * @param NotificationEvent $event
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws \yii\base\InvalidParamException
     */
    public function driverIsWaiting(NotificationEvent $event)
    {
        $from = $this->users->find($event->from_id);
        $to = $this->users->find($event->to_id);

        $notification = Notification::create(
            $event->type,
            $event->type_id,
            $event->from_id
        );
        $notification->assign($to->id);
        $order = $this->orders->find($event->type_id);

        $title = "Водитель приехал и ожидает Вас!";
        $body = "Машина: {$from->car->model} {$from->car->number}" . PHP_EOL;
        $body .= "Водитель: {$from->profile->getFullName()}" . PHP_EOL;
        foreach ($to->devices as $device) {
            $this->sendPushNotificationToDevice(
                $title,
                $body,
                $device->firebase_token,
                [
                    'id' => $order->id,
                    'type' => 'driver_is_waiting',
                    'status' => $order->status,
                ]
            );
        }
        $this->notifications->save($notification);
    }

    /**
     * @param NotificationEvent $event
     * @throws \DomainException
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     * @throws \uztelecom\exceptions\NotFoundException
     * @throws \yii\base\InvalidParamException
     */
    public function driverStartedTheRide(NotificationEvent $event)
    {
        $from = $this->users->find($event->from_id);
        $to = $this->users->find($event->to_id);

        $notification = Notification::create(
            $event->type,
            $event->type_id,
            $event->from_id
        );
        $notification->assign($to->id);
        $order = $this->orders->find($event->type_id);

        $title = "Водитель начал выполнение заказа";
        $body = "Машина: {$from->car->model} {$from->car->number}" . PHP_EOL;
        $body .= "Водитель: {$from->profile->getFullName()}" . PHP_EOL;
        foreach ($to->devices as $device) {
            $this->sendPushNotificationToDevice(
                $title,
                $body,
                $device->firebase_token,
                [
                    'id' => $order->id,
                    'type' => 'started_order',
                    'status' => $order->status,
                ]
            );
        }
        $this->notifications->save($notification);
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
            $event->type,
            $event->type_id,
            $event->from_id
        );
        $order = $this->orders->find($event->type_id);
        $title = "Новый заказ";
        $body = "От: {$order->from_address}" . PHP_EOL;
        if ($order->to_address) {
            $body .= "До: {$order->to_address}" . PHP_EOL;
        }
        $body .= "Заказчик: {$order->user->profile->getFullName()}" . PHP_EOL;

        /** @var User[] $drivers */
        foreach ($drivers as $driver) {
            $notification->assign($driver->id);
            foreach ($driver->devices as $device) {
                $this->sendPushNotificationToDevice(
                    $title,
                    $body,
                    $device->firebase_token,
                    [
                        'id' => $order->id,
                        'type' => 'new_order',
                        'status' => $order->status,
                    ]
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

        $note->setIcon('fcm_push_icon')
            ->setColor('#ffffff')
            ->setBadge(1)
            ->setSound('default');

        $message = $this->fcm->createMessage();
        $message->setNotification($note);
        if ($data) {
            $message->setData($data);
        }

        $note->setClickAction('FCM_PLUGIN_ACTIVITY');

        $message->addRecipient(new Device($firebase_token));
        $response = $this->fcm->send($message);
        $response->getStatusCode();
    }
}

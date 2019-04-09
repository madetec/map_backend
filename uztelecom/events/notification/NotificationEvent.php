<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\events\notification;


use yii\base\Event;

class NotificationEvent extends Event
{
    public $from_id;
    public $to_id;
    public $type;
    public $type_id;
    public $text;

    public static function create($from_id, $to_id, $type, $type_id, $text = null)
    {
        $notification = new static();
        $notification->from_id = $from_id;
        $notification->to_id = $to_id;
        $notification->type = $type;
        $notification->type_id = $type_id;
        $notification->text = $text;
        return $notification;
    }
}
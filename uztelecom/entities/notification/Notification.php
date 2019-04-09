<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\entities\notification;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use uztelecom\constants\Types;
use uztelecom\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class Notification
 * @package uztelecom\entities\notification
 * @property integer $id
 * @property integer $type
 * @property integer $from_id
 * @property integer $item_id
 * @property integer $created_at
 * @property NotificationAssignments[] $assignments
 * @property User[] $toUsers
 * @property User $from
 */

class Notification extends ActiveRecord implements Types
{
    public static function create($type, $item_id, $from_id): self
    {
        $notification = new static();

        $notification->type = $type;
        $notification->item_id = $item_id;
        $notification->from_id = $from_id;
        $notification->created_at = time();

        return $notification;
    }

    public function assign($to_id)
    {
        $assignments = $this->assignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isEqualTo($this->id, $to_id)) {
                return;
            }
        }
        $assignments[] = NotificationAssignments::create($to_id);
        $this->assignments = $assignments;
    }

    public function getAssignments(): ActiveQuery
    {
        return $this->hasMany(NotificationAssignments::class, ['notification_id' => 'id']);
    }

    public function getFrom(): ActiveQuery
    {
        return $this->hasOne(User::class,['id' => 'from_id']);
    }

    public function getToUsers(): ActiveQuery
    {
        return $this->hasMany(User::class, ['id' => 'to_id'])->via('assignments');
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['assignments']
            ]
        ];
    }

    public static function tableName(): string
    {
        return '{{%notifications}}';
    }
}
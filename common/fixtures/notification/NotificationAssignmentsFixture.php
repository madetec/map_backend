<?php

namespace common\fixtures\notification;

use uztelecom\entities\notification\NotificationAssignments;
use yii\test\ActiveFixture;

class NotificationAssignmentsFixture extends ActiveFixture
{
    public $modelClass = NotificationAssignments::class;
    public $dataFile = __DIR__ . "/_data/notification_assignments_data.php";
    public $depends = [NotificationFixture::class];
}
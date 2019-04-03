<?php

namespace common\fixtures\notification;

use uztelecom\entities\notification\NotificationAssignments;
use yii\test\ActiveFixture;

class NotificationAssignmentsFixture extends ActiveFixture
{
    public $modelClass = NotificationAssignments::class;
    public $depends = [NotificationFixture::class];
}
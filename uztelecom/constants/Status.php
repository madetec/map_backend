<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\constants;


interface Status
{
    const STATUS_DELETED = 0;
    const STATUS_BLOCKED = 5;
    const STATUS_ACTIVE = 10;
    const STATUS_BUSY = 15;
    const STATUS_CANCELED = 20;
    const STATUS_COMPLETED = 25;
    const STATUS_WAIT = 30;
    const STATUS_READ = 35;
    const STATUS_UNREAD = 40;
}
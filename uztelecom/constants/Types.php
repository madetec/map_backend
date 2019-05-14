<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\constants;


interface Types
{
    const TYPE_PHONES = 5;
    const TYPE_ADDRESSES = 10;

    const TYPE_NEW_ORDER = 15;
    const TYPE_NEW_USER = 20;
    const TYPE_NEW_CAR = 25;

    const TYPE_TAKE_ORDER = 30;
    const TYPE_DRIVER_IS_WAITING = 35;
    const TYPE_DRIVER_STARTED_THE_RIDE = 40;
    const TYPE_CANCEL_ORDER = 45;
    const TYPE_COMPLETED = 50;
}
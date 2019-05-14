<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\constants;


interface Event
{
    const EVENT_NEW_ORDER = 'newOrder';
    const EVENT_TAKE_ORDER = 'takeOrder';
    const EVENT_DRIVER_IS_WAITING = 'driverIsWaiting';
    const EVENT_DRIVER_STARTED_THE_RIDE = 'driverStartedTheRide';
    const EVENT_CANCEL_ORDER = 'cancelOrder';
    const EVENT_COMPLETED = 'completedOrder';

    const EVENT_BUSY = 15;
    const EVENT_CANCEL = 20;
}
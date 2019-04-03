<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\tests\unit;

use Codeception\Test\Unit;
use common\fixtures\notification\NotificationFixture;
use uztelecom\entities\notification\Notification;

class NotificationTest extends Unit
{
    public function _fixtures()
    {
        return [
            NotificationFixture::class
        ];
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testCreate()
    {
        $notification = Notification::create(
            $type = Notification::TYPE_NEW_USER,
            $item_id = 2,
            $from_id = 1
        );
        $this->assertTrue($notification->save());
        $this->assertEquals($type, $notification->type);
        $this->assertEquals($item_id, $notification->item_id);
        $this->assertEquals($from_id, $notification->from_id);
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testAssign()
    {
        $notification = Notification::create(
            $type = Notification::TYPE_NEW_USER,
            $item_id = 2,
            $from_id = 1
        );
        $notification->assign(1);
        $this->assertTrue($notification->save());

        $this->assertEquals($type, $notification->type);
        $this->assertEquals($item_id, $notification->item_id);
        $this->assertEquals($from_id, $notification->from_id);

        $this->assertEquals('admin', $notification->toUsers[0]->profile->name);
    }

}
<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\tests\unit;

use Codeception\Test\Unit;
use common\fixtures\user\ProfileFixture;
use uztelecom\entities\user\User;

class DeviceTest extends Unit
{
    public function _fixtures()
    {
        return [
            ProfileFixture::class
        ];
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testAssignToUser()
    {
        $user = User::findOne(3);
        $user->assignDevice(
            $uid = 'uid_device',
            $firebase_token = 'firebase_token',
            $name = 'Android 7.0'
        );
        $this->assertTrue($user->save());
        foreach ($user->devices as $device){
            if($device->uid === $uid){
                $this->assertEquals($firebase_token, $device->firebase_token);
                $this->assertEquals($name, $device->name);
            }
        }

    }
}

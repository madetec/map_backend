<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\tests\unit;

use Codeception\Test\Unit;
use common\fixtures\order\OrderFixture;
use uztelecom\entities\notification\Notification;
use uztelecom\entities\orders\Order;
use yii\helpers\VarDumper;

class OrderTest extends Unit
{
    public function _fixtures()
    {
        return [
            OrderFixture::class,
        ];
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testCreateWithoutToLocation()
    {
        $order = Order::create(
            $created_by = 1,
            $from_lat = 12.412,
            $from_lng = 31.3123,
            $from_address = 'Tashkent'
        );
        $this->assertTrue($order->save());
        $this->assertEquals($created_by, $order->created_by);
        $this->assertEquals($from_lat, $order->from_lat);
        $this->assertEquals($from_lng, $order->from_lng);
        $this->assertEquals($from_address, $order->from_address);


    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testCreateWithToLocation()
    {
        $order = Order::create(
            $created_by = 1,
            $from_lat = 12.412,
            $from_lng = 31.3123,
            $from_address = 'Tashkent, Mirzo-ulugbek, 10',
            $to_lat = 323.32,
            $to_lng = 3234.55,
            $to_address = 'Tashkent, Chilanzar, 18'
        );
        $this->assertTrue($order->save());
        $this->assertEquals($created_by, $order->created_by);
        $this->assertEquals($from_lat, $order->from_lat);
        $this->assertEquals($from_lng, $order->from_lng);
        $this->assertEquals($from_address, $order->from_address);
    }

    /**
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testTakeOrder()
    {
        $order = Order::create(
            $created_by = 1,
            $from_lat = 12.412,
            $from_lng = 31.3123,
            $from_address = 'Tashkent, Mirzo-ulugbek, 10',
            $to_lat = 323.32,
            $to_lng = 3234.55,
            $to_address = 'Tashkent, Chilanzar, 18'
        );
        $this->assertTrue($order->save());
        $driver_id = 2;
        $order->takeOrder($driver_id);
        $this->assertTrue($order->save());
        $this->assertEquals($driver_id, $order->driver_id);
        $this->assertEquals(Order::STATUS_BUSY, $order->status);
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testStatusComplete()
    {
        $order = Order::findOne(2);
        $order->completed();
        $this->assertTrue($order->save());
        $this->assertEquals($order->status, Order::STATUS_COMPLETED);
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testStatusCanceled()
    {
        $order = Order::findOne(1);
        $order->canceled();
        $this->assertTrue($order->save());
        $this->assertEquals($order->status, Order::STATUS_CANCELED);
    }
}
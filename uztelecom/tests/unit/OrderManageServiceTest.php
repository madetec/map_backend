<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\tests\unit;

use Codeception\Test\Unit;
use common\fixtures\order\OrderFixture;
use common\fixtures\user\ProfileFixture;
use common\fixtures\user\UserFixture;
use uztelecom\entities\orders\Order;
use uztelecom\forms\orders\OrderForm;
use uztelecom\repositories\CarRepository;
use uztelecom\repositories\OrderRepository;
use uztelecom\repositories\UserRepository;
use uztelecom\services\OrderManageService;

class OrderManageServiceTest extends Unit
{
    private $service;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->service = new OrderManageService(
            new CarRepository(),
            new UserRepository(),
            new OrderRepository()
        );
        parent::__construct($name, $data, $dataName);
    }

    public function _fixtures()
    {
        return [
            OrderFixture::class,
        ];
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function testCreateWithoutToLocation()
    {
        $created_by = 1;
        $from_lat = 12.412;
        $from_lng = 31.3123;
        $from_address = 'Tashkent';

        $orderForm = new OrderForm();
        $orderForm->from_lat = $from_lat;
        $orderForm->from_lng = $from_lng;
        $orderForm->from_address = $from_address;

        $order = $this->service->create($created_by, $orderForm);

        $this->assertEquals($created_by, $order->created_by);
        $this->assertEquals($from_lat, $order->from_lat);
        $this->assertEquals($from_lng, $order->from_lng);
        $this->assertEquals($from_address, $order->from_address);
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function testCreateWithToLocation()
    {
        $created_by = 1;
        $from_lat = 12.412;
        $from_lng = 31.3123;
        $from_address = 'Tashkent, Mirzo-ulugbek, 10';
        $to_lat = 323.32;
        $to_lng = 3234.55;
        $to_address = 'Tashkent, Chilanzar, 18';

        $orderForm = new OrderForm();
        $orderForm->from_lat = $from_lat;
        $orderForm->from_lng = $from_lng;
        $orderForm->from_address = $from_address;
        $orderForm->to_lat = $to_lat;
        $orderForm->to_lng = $to_lng;
        $orderForm->to_address = $to_address;

        $order = $this->service->create($created_by, $orderForm);

        $this->assertEquals($created_by, $order->created_by);
        $this->assertEquals($from_lat, $order->from_lat);
        $this->assertEquals($from_lng, $order->from_lng);
        $this->assertEquals($from_address, $order->from_address);
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function testTakeOrder()
    {
        $driver_id = 2;
        $order = Order::findOne(1);
        $order = $this->service->takeOrder($driver_id, $order->id);
        $this->assertEquals($driver_id, $order->driver_id);
        $this->assertEquals(Order::STATUS_BUSY, $order->status);
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function testStatusComplete()
    {
        $order = Order::findOne(2);
        $this->service->completed($order->id);
        $order = Order::findOne(2);
        $this->assertEquals($order->status, Order::STATUS_COMPLETED);
    }

    /**
     * @throws \DomainException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function testStatusCanceled()
    {
        $order = Order::findOne(1);
        $this->service->canceled($order->id);
        $order = Order::findOne(1);
        $this->assertEquals($order->status, Order::STATUS_CANCELED);
    }
}
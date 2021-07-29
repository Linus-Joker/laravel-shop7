<?php

namespace Tests\Unit\Payment;

use Tests\TestCase;

use App\Services\Orders\Payment\CreditCardPayment;

class PaymentTest extends TestCase
{
    public function __construct()
    {
        //TestCase的construct內容裡要傳入一組array 
        parent::__construct();
        $this->credit = new CreditCardPayment();
    }

    protected $validateData = [
        'name'  => 'milk',
        'email' => '123@mail.com'
    ];

    protected $orderData = [
        'name'  => 'milk',
        'email' => '123@mail.com',
        'cart'  => '1',
        'uuid'  =>  '123abc456efg789hij'
    ];

    /**
     * A validate test.
     *
     * @return void
     */
    public function testValidateTest()
    {
        // $p = new CreditCardPayment();

        $result = $this->credit->validate($this->validateData);

        $this->assertTrue($result);
    }

    public function testGetUuidTest()
    {
        $result = $this->credit->getUuid($this->validateData);
        $this->assertIsString($result);
    }

    public function testCreateOrderTableTest()
    {
        $result = $this->credit->createOrder($this->orderData);
        $this->assertTrue($result);
    }
}

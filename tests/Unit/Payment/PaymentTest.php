<?php

namespace Tests\Unit\Payment;

use Tests\TestCase;

use App\Services\Orders\Payment\CreditCardPayment;

class PaymentTest extends TestCase
{
    protected $data = [
        'name'  => 'milk',
        'email' => '123@mail.com'
    ];

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testValidateTest()
    {
        $p = new CreditCardPayment();

        $result = $p->validate($this->data);

        $this->assertTrue($result);
    }
}

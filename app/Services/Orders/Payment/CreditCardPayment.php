<?php

namespace App\Services\Orders\Payment;

use Illuminate\Support\Facades\Validator;

class CreditCardPayment extends BasePayment
{
    public function validate(array $input)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
        ];

        $validator = validator($input, $rules);

        if ($validator->fails()) {
            throw new App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }

    public function createOrder(array $data)
    {
        $this->order->create($data);

        return true;
    }
}

<?php

namespace App\Services\Orders\Payment;

use Illuminate\Support\Str;

abstract class BasePayment
{
    public function getUuid(): string
    {
        $uuid_temp = str_replace("-", "", substr(Str::uuid()->toString(), 0, 18));

        return $uuid_temp;
    }

    abstract function validate(array $data);
}

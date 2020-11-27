<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    protected function loginRule()
    {
        $rules = [
            'account' => 'required',
        ];

        $data = [
            'account' => 'test',
        ];

        $validator = validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }


    public function testRules()
    {
        $result = $this->loginRule();
        $this->assertTrue($result);
    }
}

<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Rules\Uppercase;

class RegistedTest extends TestCase
{
    protected $email = "Email";
    protected $phone = "Phone";

    /**
     * class unit test example.
     *
     * @return void
     */
    public function testCheckClassTest()
    {
        $emailClass = 'App\Services\Account\Registration\\' . $this->email;
        $ucfirstEmailClass = 'App\Services\Account\Registration\\' . ucfirst('email');

        $phoneClass = 'App\Services\Account\Registration\\' . $this->phone;
        $ucfirstPhoneClass = 'App\Services\Account\Registration\\' . ucfirst('phone');

        $this->assertEquals($emailClass, $ucfirstEmailClass);
        $this->assertEquals($phoneClass, $ucfirstPhoneClass);
    }

    public function testValidateTest()
    {
        $data = [
            'account' => 'test',
        ];
        $response = $this->json('POST', 'api/member/login', $data);
        // $response->assertOk();
        $response->assertExactJson([
            'status' => 200,
            'message' => '會員註冊成功',
            'data' => []
        ]);
    }
}

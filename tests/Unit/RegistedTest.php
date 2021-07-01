<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Rules\Uppercase;

use App\Services\Account\Registration\Email;
use App\Exceptions\InvalidParameterException;

class RegistedTest extends TestCase
{
    protected $email = "Email";
    protected $general = "General";

    /**
     * class registed unit test .
     *
     * @return void
     */
    public function testCheckClassTest()
    {
        $emailClass = 'App\Services\Account\Registration\\' . $this->email;
        $ucfirstEmailClass = 'App\Services\Account\Registration\\' . ucfirst('email');

        $generalClass = 'App\Services\Account\Registration\\' . $this->general;
        $ucfirstGeneralClass = 'App\Services\Account\Registration\\' . ucfirst('general');

        $this->assertEquals($emailClass, $ucfirstEmailClass);
        $this->assertEquals($generalClass, $ucfirstGeneralClass);
    }

    public function testEmailAccountRegisteValidate()
    {
        $data = [
            'account'   => 'test01@example.com',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password12',
        ];

        $dd = [
            'account'   => 'abc@mail.com',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password12',
        ];

        $em = new Email();

        $dataResult = $em->validate($data);
        $ddResult = $em->validate($dd);

        $this->assertTrue($dataResult);
        $this->expectException(InvalidParameterException::class);
    }

    public function testMemberRegisteValidate()
    {
        $result = $this->memberRegistedValidate();
        $this->assertTrue($result);
    }

    protected function memberRegistedValidate()
    {
        $rules = [
            'reg_email' => 'nullable|email',
            'reg_phone' => 'nullable|regex:/^09\d{8}$/',
            'password' => 'required|string|min:8|max:40',
            'sex' => 'nullable|integer',
            'type' => 'required|integer'
        ];

        $data = [
            'reg_email' => 'testaccount01@example.com',
            'reg_phone' => '0988123456',
            'password'  => 'password12',
            'sex'       => 1,
            'type'      => 1
        ];

        $validator = validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }
}

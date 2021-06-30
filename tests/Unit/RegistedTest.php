<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Rules\Uppercase;

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
        $result = $this->emailAccountRegisteValidate();
        $this->assertTrue($result);
    }

    protected function emailAccountRegisteValidate()
    {
        $rules = [
            'type'      => 'required|integer',
            'sex'       => 'required|in:1,2',
            'password'  => 'required|alpha_num|min:8|max:40',
            'account'   => 'required|email'
        ];

        $data = [
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password12',
            'account'   => 'testaccount01@example.com'
        ];

        $validator = validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
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

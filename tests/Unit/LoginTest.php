<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Models\Member;

class LoginTest extends TestCase
{
    public function testRules()
    {
        $emailResult = $this->emailLoginRule();
        $phoneResult = $this->phoneLoginRule();
        //$emailAccountData = $this->returnEmailAccountData();
        $this->assertTrue($emailResult);
        $this->assertTrue($phoneResult);
    }

    protected function emailLoginRule()
    {
        $rules = [
            'account' => 'required|email',
            'password'  => 'required'
        ];

        $data = [
            'account' => 'test@mm',
            'password'  => 'password01'
        ];

        $validator = validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }

    protected function phoneLoginRule()
    {
        $rules = [
            'account' => 'required|regex:/^09\d{8}$/',
            'password'  => 'required'
        ];

        $data = [
            'account' => '0987654321',
            'password'  => 'password01'
        ];

        $validator = validator::make($data, $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }
        return true;
    }

    public function testEmailAccountLoginDataBaseCheck()
    {
        $data = [
            'reg_email' => 'test01@mail.com',
            'password'  => 'password12'
        ];

        $this->assertDatabaseHas('member', $data);
    }

    public function testPhoneAccountLoginDataBaseCheck()
    {
        $data = [
            'reg_phone'  => '0987654321',
            'password'  => 'password22'
        ];

        $this->assertDatabaseHas('member', $data);
    }


    //如果要插入資料先用這個，懶得用工廠了
    protected function insertData()
    {
        $data = [
            'reg_email' => 'test01@mail.com',
            'password'  => 'password12'
        ];
        member::create($data);
    }
}

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

    protected function returnEmailAccountData()
    {
        $data = [
            'reg_email' => 'test01@mail.com',
        ];

        return $data;
    }

    public function testEmailAccountDB()
    {
        $data = [
            'reg_email' => 'test01@mail.com',
            'password'  => 'password12'
        ];
        member::create($data);

        $this->assertDatabaseHas('member', [
            'reg_email' => 'test01@mail.com',
            'password'  => 'password12'
        ]);
    }

    protected function checkDBdata()
    { }
}

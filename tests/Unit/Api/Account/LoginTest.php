<?php

namespace Tests\Unit\Api\Account;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Rules\Uppercase;

use App\Services\Account\Login\Email;

use App\Repositories\MemberRepository;

use App\Exceptions\DatabaseQueryException;

use function PHPSTORM_META\type;

class LoginTest extends TestCase
{
    //登入方式
    protected $email = "Email";
    protected $general = "General";

    //測試信箱登入資料
    protected $emailData = [
        'account'   => 'user1@example.com',
        'password'  => 'password123',
    ];

    //測試信箱登入異常資料
    protected $emailExceptionData = [
        'account'   => 'test02@example.com',
        'password'  => 'password',
    ];

    //測試一般登入資料
    protected $GeneralData = [
        'user_name'   => 'milk01',
        'password'  => 'password34',
    ];

    /**
     * class login feature test .
     *
     * @return void
     */

    public function testEmailAccountLoginValidate()
    {
        $em = new Email();
        $dataResult = $em->validate($this->emailData);

        $this->assertTrue($dataResult);
    }

    public function testEmailAccountLogin()
    {
        $em = new Email();

        //向登入方法傳入測試資料，得到確認後的id
        $data = $em->login($this->emailData);

        //斷言回傳的id是否有如預期得到登入者資料id
        $this->assertEquals(1, $data['id']);
    }

    public function testEmailAccountLoginException()
    {
        $this->expectException(DatabaseQueryException::class);

        $em = new Email();
        $em->login($this->emailExceptionData);
    }
}

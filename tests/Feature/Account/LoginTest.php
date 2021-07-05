<?php

namespace Tests\Unit\Feature\Account;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Rules\Uppercase;

use App\Services\Account\Login\Email;

use App\Repositories\MemberRepository;

use App\Exceptions\InvalidParameterException;

use function PHPSTORM_META\type;

class LoginTest extends TestCase
{
    protected $email = "Email";
    protected $general = "General";

    //測試信箱登入資料
    protected $emailData = [
        'account'   => 'test01@example.com',
        'password'  => 'password12',
    ];

    //測試一般登入資料
    protected $GeneralData = [
        'user_name'   => 'milk01',
        'password'  => 'password34',
    ];

    /**
     * class registed unit test .
     *
     * @return void
     */
    public function testCheckClassKind()
    {
        //...
    }

    public function testEmailAccountLoginValidate()
    {
        $em = new Email();
        $dataResult = $em->validate($this->emailData);

        $this->assertTrue($dataResult);
    }

    public function testEmailAccountLogin()
    {
        $em = new Email();
        $data = $em->login($this->emailData);

        $this->assertEquals(2, $data['id']);
    }
}

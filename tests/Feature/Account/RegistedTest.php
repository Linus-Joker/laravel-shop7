<?php

namespace Tests\Unit\Feature\Account;

use Illuminate\Support\Facades\Validator;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Rules\Uppercase;

use App\Services\Account\Registration\Email;

use App\Repositories\MemberRepository;

use App\Exceptions\InvalidParameterException;

use function PHPSTORM_META\type;

class RegistedTest extends TestCase
{
    protected $email = "Email";
    protected $general = "General";

    //測試信箱註冊資料
    protected $emailData = [
        'account'   => 'test01@example.com',
        'reg_phone' => '0987654321',
        'type'      => 1,
        'sex'       => 1,
        'password'  => 'password12',
    ];

    //測試一般註冊資料
    protected $GeneralData = [
        'user_name'   => 'milk01',
        'reg_phone' => '0912345678',
        'type'      => 1,
        'sex'       => 1,
        'password'  => 'password34',
    ];

    /**
     * class registed unit test .
     *
     * @return void
     */
    public function testCheckClassKind()
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
        $em = new Email();

        $dataResult = $em->validate($this->emailData);

        $this->assertTrue($dataResult);
    }

    public function testEmailAccountRegister()
    {
        $em = new Email();
        $memberId = $em->register($this->emailData);

        $this->assertEquals(2, $memberId);
    }

    //刻意的信箱註冊驗證異常測試，晚點加上一般註冊驗證
    public function testEmailAccountRegisteValidateException()
    {
        //在測試中以 $this->ExpectedException('ExceptionClassName'); 
        //來設定程式預期會丟出的異常，因為有異常所以過???
        $this->expectException(InvalidParameterException::class);

        $em = new Email();

        $em->validate($this->emailData);
    }

    public function testEmailAccountRegisterException()
    {
        $this->expectException(InvalidParameterException::class);

        $em = new Email();

        $em->register($this->emailData);
    }
}

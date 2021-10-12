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

/**
 * class register feature test .
 *
 * @return void
 */
class RegistrationTest extends TestCase
{
    //註冊方式
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

    //測試信箱註冊異常資料
    protected $emailExceptionData = [
        'account'   => 'abc@mail.com',
        'reg_phone' => '0987654321',
        'type'      => 1,
        'sex'       => 1,
        'password'  => '12345678',
    ];

    //測試一般註冊資料
    protected $GeneralData = [
        'user_name'   => 'milk01',
        'reg_phone' => '0912345678',
        'type'      => 1,
        'sex'       => 1,
        'password'  => 'password34',
    ];

    //開始前先重新遷移資料表
    public function setUp(): void
    {
        parent::setUp();

        $this->initDatabase();
    }

    public function testEmailAccountRegisteValidate()
    {
        $em = new Email();

        $dataResult = $em->validate($this->emailData);

        $this->assertTrue($dataResult);
    }

    public function testEmailAccountRegister()
    {
        //生成Email class 
        $em = new Email();

        //向註冊方法傳入測試資料，得到插入後的id
        $memberId = $em->register($this->emailData);

        //斷言回傳的id是否有如預期註冊成功
        $this->assertEquals(2, $memberId);
    }

    //刻意的信箱註冊驗證異常測試，晚點加上一般註冊驗證
    public function testEmailAccountRegisteValidateException()
    {
        //在測試中以 $this->ExpectedException('ExceptionClassName'); 
        //來設定程式預期會丟出的異常，因為有異常所以過???
        $this->expectException(InvalidParameterException::class);

        $em = new Email();

        //驗證是否傳入異常資料後會回丟出異常
        $em->validate($this->emailExceptionData);
    }

    public function testEmailAccountRegisterException()
    {
        $this->expectException(InvalidParameterException::class);

        $em = new Email();

        $em->register($this->emailExceptionData);
    }
}

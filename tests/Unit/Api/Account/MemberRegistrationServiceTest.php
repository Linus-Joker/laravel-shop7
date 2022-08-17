<?php

namespace Tests\Unit\Api\Account;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Services\Account\Registration\Email;
use App\Services\Account\Registration\General;

use App\Exceptions\InvalidParameterException;

/**
 * class register service unit test .
 *
 * @return void
 */
class MemberRegistrationServiceTest extends TestCase
{
    //註冊方式
    protected $email = "Email";
    protected $general = "General";

    //測試信箱註冊資料
    protected $emailData = [
        'account'   => 'user1@example.com',
        'user_name' => 'user1',
        'reg_phone' => '0987654321',
        'type'      => 1,
        'sex'       => 1,
        'password'  => 'password12',
    ];

    //測試信箱註冊異常資料
    /*1.在member table 裡面user_name 的欄位是不允許空值
    *所以我給這筆正常的資料後，測試並不能如期的出現exception
    *phpUnit給我測試錯誤訊息，FF未通過測試
    *2.不給user_name 的值後，因為有發生預期的exception
    *所以測試通過(目前先這樣下定論) 
    */
    protected $emailExceptionData = [
        'account'   => 'abc@mail.com',
        // 'user_name'   => 'user4', //沒有新增使用者
        'reg_phone' => '0987654321',
        'type'      => 1,
        'sex'       => 1,
        'password'  => '12345678',
    ];

    //測試一般註冊資料
    protected $GeneralData = [
        'account'   => 'milk01',
        'reg_phone' => '0912345678',
        'type'      => 1,
        'sex'       => 1,
        'password'  => 'password34',
    ];

    private $checkEmail = 'user1@example.com';

    // 開始前先重新遷移資料表(每個函式前都會執行)
    // public function setUp(): void
    // {
    //     parent::setUp();

    //     $this->initDatabase();
    // }

    //測試前後遷移資料表
    use RefreshDatabase;

    public function testEmailAccountRegisterValidate()
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
        $this->assertEquals(1, $memberId);
    }

    /**
     * @expectedException \InvalidParameterException
     */
    //刻意的信箱註冊驗證異常測試，晚點加上一般註冊驗證
    public function testEmailAccountRegisterValidateException()
    {
        //在測試中以 $this->ExpectedException('ExceptionClassName'); 
        //來設定程式預期會丟出的異常，因為有異常所以過???
        $this->expectException(InvalidParameterException::class);

        $em = new Email();

        //驗證是否傳入異常資料後會丟出異常
        $em->validate($this->emailExceptionData);
    }

    /**
     * @expectedException \InvalidParameterException
     */
    //刻意的信箱註冊異常測試
    public function testEmailAccountRegisterException()
    {
        $this->expectException(InvalidParameterException::class);

        $em = new Email();

        $em->register($this->emailExceptionData);
    }

    public function testGeneralAccountRegisterValidate()
    {
        //生成general class 
        $general = new General();

        //向註冊驗證風法傳入測試資料，成功傳回True
        $dataResult = $general->validate($this->GeneralData);

        $this->assertTrue($dataResult);
    }

    public function testGeneralAccountRegister()
    {
        //生成general class 
        $general = new General();

        //向註冊方法傳入測試資料，得到插入後的id
        $memberId = $general->register($this->GeneralData);

        //斷言回傳的id是否有如預期註冊成功
        $this->assertEquals(2, $memberId);
    }
}

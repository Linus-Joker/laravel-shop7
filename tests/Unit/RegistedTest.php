<?php

namespace Tests\Unit;

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
        //測試信箱註冊資料
        $data = [
            'account'   => 'test01@example.com',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password12',
        ];

        //要測試異常的資料
        $dd = [
            'account'   => 'abc@mail.com',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password12',
        ];

        $em = new Email();

        $dataResult = $em->validate($data);
        //這邊本來要測試異常狀況，先等等
        // $ddResult = $em->validate($dd);

        $this->assertTrue($dataResult);
        // $this->expectException(InvalidParameterException::class);
    }

    public function testCreate()
    {
        $data = [
            'reg_email'     => 'test01@example.com',
            'type'          => 1,
            'sex'           => 1,
            'password'      => 'password12',
        ];

        $mr = new MemberRepository();
        $memberId = $mr->create($data);

        $this->assertEquals(2, $memberId);
    }
}

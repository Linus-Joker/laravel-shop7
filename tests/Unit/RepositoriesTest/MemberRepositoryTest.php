<?php

namespace Tests\Unit\RepositoriesTest;

use Tests\TestCase;

use App\Repositories\MemberRepository;

use App\Exceptions\InvalidParameterException;


class MemberRepositoryTest extends TestCase
{
    protected $rules;

    public function testMemberRepositoryValidate()
    {
        $emailData = [
            'reg_email'   => 'test01@example.com',
            'reg_phone' => '0987654321',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password12',
        ];

        $GeneralData = [
            'user_name'   => 'milk01',
            'reg_phone' => '0912345678',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password34',
        ];

        $mr = new MemberRepository();

        $emailValidateResult = $mr->validate($emailData);
        $generalValidateResult = $mr->validate($GeneralData);

        $this->assertTrue($emailValidateResult);
        $this->assertTrue($generalValidateResult);
    }

    public function testMemberException()
    {
        $emailData = [
            'reg_email'   => 'abc@mail.com',
            'reg_phone' => '0912345678',
            'type'      => 1,
            'sex'       => 1,
            'password'  => 'password34',
        ];

        //在測試中以 $this->ExpectedException('ExceptionClassName'); 
        //來設定程式預期會丟出的異常，因為有異常所以過???
        $this->expectException(InvalidParameterException::class);

        $mr = new MemberRepository();

        $mr->validate($emailData);
    }
}

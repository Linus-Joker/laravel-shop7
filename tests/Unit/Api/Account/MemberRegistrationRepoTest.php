<?php

namespace Tests\Unit\Api\Account;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Repositories\MemberRepository;

use App\Exceptions\InvalidParameterException;

/**
 * class register service unit test .
 *
 * @return void
 */
class MemberRegistrationRepoTest extends TestCase
{
    //測試前後遷移資料表
    use RefreshDatabase;

    //測試信箱註冊資料
    private $emailData = [
        'reg_email' => 'user1@example.com',
        'user_name' => 'user1',
        'password'  => 'password12',
        'type'      => 1,
    ];

    //測試一般註冊資料
    private $generalData = [
        'user_name' => 'user2',
        'reg_phone' => '0912345678',
        'password'  => 'password22',
        'type'      => 1,
    ];

    public function testMemberRepoEmailValidate()
    {
        //create member repo class
        $mr = new MemberRepository();

        //pass email data validate
        $dataResult = $mr->validate($this->emailData);

        $this->assertTrue($dataResult);
    }

    public function testMemberRepoEmailCreate()
    {
        $mr = new MemberRepository();
        $mr->create($this->emailData);
        $this->assertDatabaseHas('member', ['reg_email' => 'user1@example.com']);
    }

    public function testMemberRepoGeneralValidate()
    {
        $mr = new MemberRepository();
        $dataResult = $mr->validate($this->generalData);

        $this->assertTrue($dataResult);
    }

    public function testMemberRepoGeneralCreate()
    {
        $mr = new MemberRepository();
        $mr->create($this->generalData);
        $this->assertDatabaseHas('member', ['user_name' => 'user2']);
    }

    public function testCheckEmailAccountDB()
    {
        $data = [
            'reg_email' => 'user3@example.com',
            'user_name' => 'user3',
            'password'  => 'password33',
            'type'      => 1,
        ];

        $mr = new MemberRepository();
        $mr->create($data);

        $memberData = $mr->checkEmailAccountDB($data['reg_email']);

        $this->assertEquals(3, $memberData['id']);
        $this->assertEquals('user3', $memberData['user_name']);
    }
}

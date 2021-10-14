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
    use RefreshDatabase;

    private $emailData = [
        'reg_email' => 'user1@example.com',
        'user_name' => 'user1',
        'password'  => 'password12',
        'type'      => 1,
    ];

    public function testMemberRepoEmailValidate()
    {
        $mr = new MemberRepository();
        $dataResult = $mr->validate($this->emailData);

        $this->assertTrue($dataResult);
    }

    public function testMemberRepoEmailCreate()
    {
        $mr = new MemberRepository();
        $mr->create($this->emailData);
        $this->assertDatabaseHas('member', ['reg_email' => 'user1@example.com']);
    }


    public function testCheckEmailAccountDB()
    {
        $data = [
            'reg_email' => 'user2@example.com',
            'user_name' => 'user2',
            'password'  => 'password22',
            'type'      => 1,
        ];

        $mr = new MemberRepository();
        $mr->create($data);

        $memberData = $mr->checkEmailAccountDB($data['reg_email']);

        $this->assertEquals(2, $memberData['id']);
        $this->assertEquals('user2', $memberData['user_name']);
    }
}

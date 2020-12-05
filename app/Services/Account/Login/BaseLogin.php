<?php

namespace App\Services\Account\Login;

use Illuminate\Support\Facades\Hash;
use App\Repositories\MemberRepository;

abstract class BaseLogin
{
    protected $member;

    public function __construct()
    {
        $this->member = new MemberRepository();
    }

    /**
     * 檢查hash密碼
     *
     * @param str $transferPassword, $dbPassword
     *      @var string $transferPassword 使用者傳過來的會員帳號
     *      @var string $dbPassword 資料庫hash密碼
     * @return array
     */

    public function checkPassword($transferPassword, $dbPassword)
    {
        if (Hash::check($transferPassword, $dbPassword)) {
            return true;
        }

        throw new \App\Exceptions\DatabaseQueryException('你輸入的帳號或密碼錯誤，請重新輸入');
    }
}

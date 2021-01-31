<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Facades\Validator;
use App\Admin;

class AdminRepository
{
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin();
    }

    /**
     * 尋找會員資料
     *
     * @param str $checkData
     * @var string $data['account'] 使用者傳過來的會員帳號
     * @return array
     */

    public function checkAccountDB($checkData)
    {
        $AdminData = $this->admin::where('admin_codename', $checkData)
            ->first();

        if (empty($AdminData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('你輸入的帳號或密碼錯誤，請重新輸入');
        }

        return $AdminData;
    }
}

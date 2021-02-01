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

    public function checkSessionDB($checkData)
    {
        $AdminData = $this->admin::where('id', $checkData)
            ->first();

        if (empty($AdminData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('找不到管理員或者權限錯誤');
        }

        return true;
    }

    public function changePasswordDB($newPassword, $id)
    {
        $adminPassword = $this->admin::find($id);
        if (empty($adminPassword)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('找不到管理員或者權限錯誤');
        }
        $adminPassword->password = $newPassword;

        if ($adminPassword->save() !== true) {
            throw new \App\Exceptions\DatabaseQueryException('password change fails.');
        }
        $adminPassword->save();
    }
}

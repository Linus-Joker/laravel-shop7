<?php

namespace App\Services\Admin;

use DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Admin\AdminRepository;

class AdminServices
{
    protected $admin;

    public function __construct()
    {
        $this->admin = new AdminRepository();
    }

    public function login($data)
    {
        $rules = [
            'account' => 'required',
            'password'  => 'required|min:8|max:40'
        ];
        $this->validate($data, $rules);

        $adminData = $this->admin->checkAccountDB($data['account']);
        //還有檢查密碼，因為還沒寫hash所以先不用
        $data = [
            'id'    => $adminData['id']
        ];

        return $data;
    }

    public function checkSession()
    {
        //因為session還沒做，先這樣辨別session
        $checkSession = 1;

        if (empty($checkSession)) {
            throw new \App\Exceptions\InvalidParameterException('session error');
        }

        $adminData = $this->admin->checkSessionDB($checkSession);

        return $adminData;
    }

    public function checkPassword($data)
    {
        $rules = [
            'new_password' => 'required|min:8|max:40',
            'confirm_password'  => 'required|min:8|max:40'
        ];

        $this->validate($data, $rules);

        if ($data['new_password'] == $data['confirm_password']) {
            return $data['new_password'];
        } else {
            throw new \App\Exceptions\InvalidParameterException('Confirm Password Inconsistent');
        }
    }

    public function changePassword($newPassword, $id)
    {
        $this->admin->changePasswordDB($newPassword, $id);

        return true;
    }

    protected function validate($checkData, $rules)
    {
        $validator = validator::make($checkData, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }
}

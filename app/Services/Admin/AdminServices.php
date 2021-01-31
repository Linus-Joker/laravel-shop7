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
        $this->validate($data);
        $adminData = $this->admin->checkAccountDB($data['account']);
        //還有檢查密碼，因為還沒寫hash所以先不用
        $data = [
            'id'    => $adminData['id']
        ];

        return $data;
    }

    protected function validate($checkData)
    {
        $rules = [
            'account' => 'required',
            'password'  => 'required|min:8|max:40'
        ];

        $validator = validator::make($checkData, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }
}

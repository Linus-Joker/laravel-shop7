<?php

namespace App\Services\Account\Login;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberRepository;

class Email extends BaseLogin
{
    public function login($data)
    {
        $this->validate($data);
        //這裡應該要寫成介面?
        $memberData = $this->member->checkEmailAccountDB($data['account']);

        //hash password check寫在共通的地方
        $this->checkPassword($data['password'], $memberData['password']);

        //假設都沒問題那我返回sex,type,status，因為要給前端傳資料??
        $data = [
            'id'        => $memberData['id'],
            'sex'       => $memberData['sex'],
            'type'      => $memberData['type'],
            'status'    => $memberData['status'],
        ];
        //有問題再重構吧!!
        return $data;
    }

    public function validate($checkData)
    {
        $rules = [
            'account' => 'required|email',
            'password'  => 'required|min:8|max:40'
        ];

        $validator = validator::make($checkData, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }
}

<?php

namespace App\Services\Account\Registration;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberRepository;
use Illuminate\Support\Str;


class Email extends BaseRegistration
{
    protected $type = 1;

    public function register($data)
    {
        //應該要到Repository插入註冊資料
        $this->validate($data);

        $insertData = [
            'sex' => $data['sex'] ?? null,
            'type' => $this->type,
            'password' => $data['password'],
            'reg_email' => $data['account']
        ];

        $memberId = $this->member->create($insertData);

        return $memberId;
    }

    public function validate($input)
    {
        $input['type'] = $this->type;
        // $rules['account'] = 'required|email|unique:member,reg_email';
        $rules = [
            'type'      => 'required|integer',
            'sex'       => 'required|in:1,2',
            'password'  => 'required|password|min:8|max:40',
            // 'account'   => 'required|email|unique:App\Models\Member,reg_email'
        ];

        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            // throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
            return $validator->errors();
        }

        return true;
    }

    public function getActivateCode()
    {
        return Str::random(64);
    }
}
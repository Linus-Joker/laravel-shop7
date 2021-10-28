<?php

namespace App\Services\Account\Registration;

use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberRepository;
use Illuminate\Support\Str;


class Email extends BaseRegistration
{
    protected $type = 1;

    /**
     * 驗證傳送過來的資料，並送到Member()類，
     * 插入資料並得到返回會員ID
     * 
     * @param array $data[
     *      @var int $sex 性別，1:男, 2:女
     *      @var string $type 註冊類型，1:email, 2:一般, 3:其他
     *      @var string $password  密碼
     *      @var string $reg_email 註冊的 email
     * ]
     * @return int $memberId 會員ID
     */

    public function register($data)
    {
        $this->validate($data);

        $insertData = [
            'sex' => $data['sex'] ?? null,
            'user_name' => $data['user_name'],
            'type' => $this->type,
            'password' => $data['password'],
            'reg_email' => $data['account']
        ];

        //應該要到Repository插入註冊資料
        $memberId = $this->member->create($insertData);

        return $memberId;
    }

    public function validate($input)
    {
        $input['type'] = $this->type;
        // $rules['account'] = 'required|email|unique:member,reg_email';
        $rules = [
            'account'   => 'required|email|unique:member,reg_email',
            'user_name' => 'required',
            'type'      => 'required|integer',
            'sex'       => 'required|in:1,2,3',
            'password'  => 'required|alpha_num|min:8|max:40',
        ];

        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
            // return $validator->errors();
        }

        return true;
    }

    public function getActivateCode()
    {
        return Str::random(64);
    }
}

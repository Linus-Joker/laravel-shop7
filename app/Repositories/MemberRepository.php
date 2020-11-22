<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use App\Models\Member;

class MemberRepository
{
    private $member;

    public function __construct()
    {
        $this->member = new Member();
    }

    /**
     * 新增一筆會員資料
     *
     * @param array $data[
     *      @var string $reg_email 註冊的 email
     *      @var string $reg_phone 註冊的手機號碼
     *      @var string $password  密碼
     *      @var int    $sex       性別，1:男, 2:女
     *      @var string $type      註冊類型，1:email, 2:手機
     * ]
     * @return void
     */

    public function create(array $data)
    {
        $rules = [
            'reg_email' => 'nullable|email',
            'reg_phone' => 'nullable|regex:/^09\d{8}$/',
            'password' => 'required|string|min:8|max:16',
            'sex' => 'nullable|integer',
            'type' => 'required|integer'
        ];

        $this->validate($data, $rules);

        $this->member->reg_email = $data['reg_email'] ?? null;
        $this->member->reg_phone = $data['reg_phone'] ?? null;
        $this->member->password = $data['password'];
        $this->member->sex = $data['sex'] ?? null;
        $this->member->type = $data['type'];
        $this->member->save();

        return $this->member->id;
    }

    public function validate(array $input, array $rules)
    {
        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }
}

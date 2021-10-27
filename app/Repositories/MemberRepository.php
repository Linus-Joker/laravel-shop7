<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
     *      @var string $type      註冊類型，1:email, 2:一般, 3:其他
     * ]
     * @return int $id 會員ID
     */

    public function create(array $data)
    {
        $this->validate($data);

        try {
            $this->member->reg_email = $data['reg_email'] ?? null;
            $this->member->reg_phone = $data['reg_phone'] ?? null;
            $this->member->user_name = $data['user_name'] ?? null;
            $this->member->password = $this->hashPassword($data['password']);
            $this->member->sex = $data['sex'] ?? null;
            $this->member->type = $data['type'];
            // $this->member->save();
            if ($this->member->save() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('新增 member 資料表失敗');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

        return $this->member->id;
    }

    public function validate(array $input)
    {
        $rules = [
            'reg_email' => 'nullable|email|unique:member,reg_email',
            'reg_phone' => 'nullable|regex:/^09\d{8}$/',
            'user_name' => 'required|alpha_num',
            'password' => 'required|alpha_num|min:8|max:40',
            'sex' => 'nullable|integer|min:1|max:3',
            'type' => 'required|integer|min:1|max:3'
        ];

        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            // return $validator->errors();
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }

    /**
     * Email尋找會員資料
     *
     * @param str $checkData
     *      @var string $data['account'] 使用者傳過來的會員帳號
     * @return array
     */

    public function checkEmailAccountDB($checkData)
    {
        $memberData = $this->member::where('reg_email', $checkData)
            ->first();

        if (empty($memberData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('你輸入的帳號或密碼錯誤，請重新輸入');
        }

        return $memberData;
    }

    /**
     * 一般user_name尋找會員資料
     *
     * @param str $checkData
     *      @var string $data['account'] 使用者傳過來的會員帳號
     * @return array
     */

    public function checkUserNameAccountDB($checkData)
    {
        $memberData = $this->member::where('user_name', $checkData)
            ->first();

        if (empty($memberData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('你輸入的帳號或密碼錯誤，請重新輸入');
        }

        return $memberData;
    }

    public function checkUserIdAccountDB(int $user_id)
    {
        $memberData = $this->member::find($user_id);

        if (empty($memberData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('找不到使用者，請重新登入');
        }

        return $memberData;
    }

    public function changePassword($newPassword, $user_id)
    {
        try {
            $hashNewPassword = $this->hashPassword($newPassword);

            $user = $this->member::find($user_id);

            $user->password = $hashNewPassword;

            if ($user->save() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('更新使用者密碼失敗');
            }
        } catch (\Throwable $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }
        return true;
    }

    public function hashPassword($password)
    {
        $hashPassword = Hash::make($password, [
            'rounds' => 12
        ]);

        return $hashPassword;
    }
}

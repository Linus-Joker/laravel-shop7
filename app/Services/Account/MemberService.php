<?php

namespace App\Services\Account;

use Illuminate\Support\Facades\Validator;

use App\Repositories\MemberRepository;

use Illuminate\Support\Facades\Hash;

class MemberService
{
    protected $member;

    public function __construct()
    {
        $this->member = new MemberRepository();
    }

    public function validate($data)
    {
        $rules = [
            "oldPassword" => 'required|alpha_num|min:8|max:40',
            "newPassword" => 'required|alpha_num|min:8|max:40',
            "checkPassword" => 'required|alpha_num|min:8|max:40',
        ];

        $validator = validator::make($data, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
            // return $validator->errors();
        }

        return true;
    }

    public function checkUserId($user_id)
    {
        $memberData = $this->member->checkUserIdAccountDB($user_id);

        return $memberData;
    }

    public function hashPassword($oldPassword)
    {
        $oldHashPassword = $this->member->hashPassword($oldPassword);
        return $oldHashPassword;
    }

    public function checkPassword($oldHashPassword, $userHashPassword)
    {
        if (Hash::check($oldHashPassword, $userHashPassword)) {
            return true;
        }

        throw new \App\Exceptions\DatabaseQueryException('你輸入的密碼錯誤，請重新輸入');
    }

    public function changePassword($newPassword, $user_id)
    {
        $changeResult = $this->member->changePassword($newPassword, $user_id);

        return $changeResult;
    }
}

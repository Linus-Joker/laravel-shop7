<?php

namespace App\Services\Account;

use Illuminate\Support\Facades\Validator;

use App\Repositories\MemberRepository;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberService
{
    protected $member;

    public function __construct()
    {
        $this->member = new MemberRepository();
    }

    public function validate(array $data, array $rules)
    {
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

    public function checkEmailAccountDB($user_email)
    {
        $memberData = $this->member->checkEmailAccountDB($user_email);

        return $memberData;
    }

    public function hashPassword($password)
    {
        // $HashPassword = $this->member->hashPassword($password);
        // return $HashPassword;

        $hashPassword = Hash::make($password, [
            'rounds' => 12
        ]);

        return $hashPassword;
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

    public function getTemporaryPassword()
    {
        $aaa = 'abcd1234';
        // return Str::random(8);
        return $aaa;
    }
}

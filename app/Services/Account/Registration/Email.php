<?php

namespace App\Services\Account\Registration;

use App\Models\Member;
use Illuminate\Support\Facades\Validator;

class Email
{
    protected $type = 1;

    public function validate($input)
    {
        $input['type'] = $this->type;

        $rules['account'] = 'required|email|unique:member,reg_email';
        $rules = [
            'type'      => 'required|integer',
            'sex'       => 'required|integer',
            'password'  => 'required|min:8|max:20',
        ];

        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }

        $result = [
            'code'      => 200,
            'message'   => 'validate ok!!'
        ];
        return $result;
    }

    public function register($data)
    {
        return $this->validate($data);
    }
}

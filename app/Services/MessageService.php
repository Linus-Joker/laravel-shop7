<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class MessageService
{
    public function validate($input)
    {
        $rules = [
            'product_id'            => 'required|numeric',
            'user_id'               => 'required|numeric',
            'message_content'       =>  'required|max:512',
        ];

        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
            // return $validator->errors();
        }

        return true;
    }
}

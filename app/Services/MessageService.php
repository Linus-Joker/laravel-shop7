<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

use App\Repositories\MessageRepository;

class MessageService
{
    public function __construct()
    {
        $this->message = new MessageRepository();
    }

    /**
     * 驗證傳送過來的資料，並送到Message類建立留言資料
     * 
     * @param array $data[
     *      @var int $product_id 產品ID
     *      @var int $user_id 使用者ID
     *      @var string $message_content 留言內容
     * ]
     * @return void
     */

    public function insert($data)
    {
        $this->validate($data);

        $this->message->create($data);

        return true;
    }

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

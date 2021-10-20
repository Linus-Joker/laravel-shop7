<?php

namespace App\Repositories;

use App\Message;

class MessageRepository
{
    private $message;

    public function __construct()
    {
        $this->message = new Message();
    }

    /**
     * 新增一筆留言資料
     * 
     * @param int $product_id 產品ID
     * @return array productData 
     */
    public function create(array $data)
    {
        try {
            $this->message::create($data);
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }
    }
}

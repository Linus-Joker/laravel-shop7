<?php

namespace App\Repositories;

use App\Orders;

class OrdersRepository
{
    private $order;

    public function __construct()
    {
        $this->order = new Orders();
    }

    /**
     * 新增一筆訂單資料
     *
     * @param array $data[
     *      @var string $name 訂單姓名
     *      @var string $email 訂單Email
     *      @var text   $cart 購物車資料
     *      @var string $uuid 訂單編號
     * ]
     * @return void
     */
    public function create(array $data)
    {
        $rules = [
            'name'  =>  'required|string',
            'email' =>  'required|email',
            'cart'  =>  'required',
            'uuid'  =>  'required|string',
        ];

        $this->validate($data, $rules);

        try {
            $this->order->name = $data['name'];
            $this->order->email = $data['email'];
            $this->order->cart = $data['cart'];
            $this->order->uuid = $data['uuid'];

            if ($this->order->save() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('新增訂單資料表失敗');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

        return true;
    }

    private function validate(array $input, array $rules)
    {
        $validator = validator($input, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }
}

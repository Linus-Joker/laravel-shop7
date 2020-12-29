<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use App\Books;

class ProductRepository
{
    private $book;

    public function __construct()
    {
        $this->book = new Books();
    }

    /**
     * 商品資料
     *
     * @param array $data[
     *      @var string $name 商品名稱
     *      @var string $description 商品描述
     *      @var int    $price 商品價格
     * ]
     * @return binary
     */

    public function create($data)
    {
        $rules = [
            'name'          => 'required|max:255',
            'description'   => 'required|max:255',
            'price'         => 'required|integer',
        ];

        $this->validate($data, $rules);

        try {
            $this->book->name = $data['name'];
            $this->book->description = $data['description'];
            $this->book->price = $data['price'];

            if ($this->book->save() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('新增 book 資料失敗');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

        return true;
    }

    public function update($data, $id)
    {
        $rules = [
            'name'          => 'nullable|max:255',
            'description'   => 'nullable|max:255',
            'price'         => 'nullable|integer',
        ];
        $this->validate($data, $rules);

        $bookData = $this->book::find($id);
        if (empty($bookData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('ID錯誤!!');
        }

        try {
            $bookData->update($data);
            if ($bookData->update() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('更新 book 資料失敗');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

        return true;
    }

    public function delete($id)
    {
        $bookData = $this->book::find($id);
        if (empty($bookData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('ID錯誤!!');
        }

        $bookData->delete();
        return true;
    }


    protected function validate($input, array $rules)
    {
        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            // return $validator->errors();
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
        }

        return true;
    }
}

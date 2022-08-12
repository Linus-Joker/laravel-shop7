<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Facades\Validator;
use App\Books;
use App\ProductImage;

class ProductRepository
{
    private $book;

    public function __construct()
    {
        $this->book = new Books();
        $this->productImage = new ProductImage();
    }

    public function show($id)
    {
        $bookData = $this->book::find($id);
        if (empty($bookData)) {
            throw new \App\Exceptions\DatabaseQueryException('找不到該id產品!!');
        }

        return $bookData;
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
            'name'              => 'required|max:255',
            'description'       => 'required|max:255',
            'price'             => 'required|integer',
            'products_sort_id'  => 'required|integer',
        ];

        $this->validate($data, $rules);

        try {
            $this->book->name = $data['name'];
            $this->book->description = $data['description'];
            $this->book->price = $data['price'];
            $this->book->products_sort_id = $data['products_sort_id'];

            if ($this->book->save() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('新增 book 資料失敗');
            }
        } catch (\Exception $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

        // dd($this->book->id);
        return $this->book->id;
    }

    /**
     * $param array $imageData
     * $param int $product_id
     * @return bool 
     */
    public function createPic(array $imageData, int $product_id)
    {
        try {
            $this->productImage->image_name = $imageData['file_name'];
            $this->productImage->image_path = $imageData['image_path'];
            $this->productImage->products_id = $product_id;
            if ($this->productImage->save() !== true) {
                throw new \App\Exceptions\DatabaseQueryException('新增 product image 失敗');
            }
        } catch (\Throwable $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

        return true;
    }

    public function update($data, $id)
    {
        $rules = [
            'name'              => 'nullable|max:255',
            'description'       => 'nullable|max:255',
            'price'             => 'nullable|integer',
            'products_sort_id'  => 'nullable|integer',
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

    public function updatePic($imageData, $product_id)
    {
        $productImageData = $this->productImage::where('products_id', '=', $product_id)
            ->get();
        if (empty($productImageData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('產品ID錯誤!!');
        }

        $this->productImage::where('products_id', '=', $product_id)
            ->update([
                'image_name' => $imageData['file_name'],
                'image_path' => $imageData['image_path']
            ]);

        return true;
    }

    public function delete($id)
    {
        $bookData = $this->book::find($id);
        if (empty($bookData)) {
            // return '你輸入的帳號或密碼錯誤，請重新輸入';
            throw new \App\Exceptions\DatabaseQueryException('ID錯誤!!');
        }
        try {
            $bookData->delete();

            $this->productImage::where('products_id', '=', $id)->delete();
        } catch (\Throwable $e) {
            throw new \App\Exceptions\DatabaseQueryException($e->getMessage());
        }

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

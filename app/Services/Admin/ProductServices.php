<?php

namespace App\Services\Admin;

use DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Admin\ProductRepository;


class ProductServices
{
    protected $product;

    public function __construct()
    {
        $this->products = new ProductRepository();
    }

    public function show($id)
    {
        $bookData = $this->products->show($id);

        return $bookData;
    }

    /**
     * @param $require->input $data
     * @return int $product_id
     */
    public function create($data)
    {
        $product_id = $this->products->create($data);

        return $product_id;
    }

    /**
     * @param array $imageData
     * @param int $product_id 
     * @return void
     */
    public function createPic(array $imageData, int $product_id)
    {
        $validateData = [
            'product_id'    => $product_id,
            'file_name'     => $imageData['file_name'],
            'image_path'    => $imageData['image_path']
        ];

        $rules = [
            'product_id'    => 'required',
            'file_name'     => 'required',
            'image_path'    => 'required'
        ];

        $this->validate($validateData, $rules);

        $this->products->createPic($imageData, $product_id);
    }

    /**
     * @param $require->input $data
     * @param int $id
     * @return bool
     */
    public function update($data, $id)
    {
        $this->products->update($data, $id);

        return true;
    }

    public function updatePic($imageData, $product_id)
    {
        $validateData = [
            'product_id'    => $product_id,
            'file_name'     => $imageData['file_name'],
            'image_path'    => $imageData['image_path']
        ];

        $rules = [
            'product_id'    => 'required',
            'file_name'     => 'required',
            'image_path'    => 'required'
        ];

        $this->validate($validateData, $rules);

        $this->products->updatePic($imageData, $product_id);
    }

    public function delete($id)
    {
        $this->products->delete($id);

        return true;
    }

    /**
     * @param image $data $request-file('pci_file'); 
     * @return void
     */
    public function uploadImage($data)
    {
        //副檔名，在原DOC中是$request->photo->extension();
        //不是$request-file('')->extension(); 
        $extension = $data->extension();
        $file_name = time() . rand(0, 327677) . "." . $extension;

        //放置圖片位置
        $image_path = public_path('images');

        //rule mimes是驗證整個文件，所以必須傳文件進去驗證
        $validateData = [
            'data' => $data,
            'file_name' => $file_name,
            'image_path' => $image_path
        ];

        //驗證文件的副檔名(jpg,jpeg,png)，名稱和位置
        $rules = [
            'data' => 'required|mimes:jpeg,png,jpg',
            'file_name' => 'required',
            'image_path' => 'required'
        ];

        $this->validate($validateData, $rules);

        //這個方法在Laravel5.2的中文Doc才有
        $data->move($image_path, $file_name);

        return [
            'image_path' => $image_path,
            'file_name' => $file_name
        ];
    }

    public function validate($input, $rules)
    {
        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
            // return $validator->errors();
        }

        return true;
    }
}

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

    /**
     * 取得單一產品資料
     * 
     * @param int $id
     * @return @bookData
     * 
     */
    public function show($id)
    {
        $bookData = $this->products->show($id);

        return $bookData;
    }

    /**
     * 新增一筆產品資料
     * @param $require->input $data
     * @return int $product_id
     */
    public function create($data)
    {
        $product_id = $this->products->create($data);

        return $product_id;
    }

    /**
     * 新增一筆圖片文件
     * @param array $imageData[
     *      @var string $image_path 圖片路徑
     *      @var string @image_name 圖片名稱  
     * ]
     * @param int $product_id 
     * @return void
     */
    public function createPic(array $imageData, int $product_id)
    {
        $validateData = [
            'product_id'    => $product_id,
            'file_name'     => $imageData['file_name'],
        ];

        $rules = [
            'product_id'    => 'required',
            'file_name'     => 'required',
        ];

        $this->validate($validateData, $rules);

        $this->products->createPic($imageData, $product_id);
    }

    /**
     * @param $require->input $data[
     *      @var string $name 商品名稱
     *      @var string $description 商品描述
     *      @var int    $price 商品價格
     *      @var int    $products_sort_id 產品分類ID
     * ]
     * @param int $id
     * @return bool
     */
    public function update($data, $id)
    {
        $this->products->update($data, $id);

        return true;
    }

    /**
     * 更新一筆圖片文件(這個感覺要另外寫class)
     * @param array $imageData[
     *      @var string $image_path 圖片路徑
     *      @var string @image_name 圖片名稱  
     * ]
     * @param int $product_id 產品ID
     * @return void 
     */
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

    /**
     * 刪除一筆資料
     * 
     * @param int $id product id
     * @return boolean
     */
    public function delete($id)
    {
        $this->products->delete($id);

        return true;
    }

    /**
     * 上傳圖片文件
     * @param image $data $request-file('pci_file'); 
     * @return void
     */
    public function uploadImage($data)
    {
        //副檔名，在原DOC中是$request->photo->extension();
        //不是$request-file('')->extension(); 
        $extension = $data->extension();
        $file_name = time() . rand(0, 1048577) . "." . $extension;

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

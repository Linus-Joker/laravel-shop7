<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Repositories\Admin\ProductRepository;

class ImageServices
{
    public function __construct()
    {
        $this->products = new ProductRepository();
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

    /**
     * 取得一筆產品圖片資料
     * 
     * @param int $id
     * @return @imageData
     * 
     */
    public function showPic($id)
    {
        $imageData = $this->products->showPic($id);

        return $imageData;
    }

    /**
     * 刪除在儲存庫的圖片文件
     * @param string $image_name
     * @return boolean 
     */
    public function deletePicture(string $image_name)
    {
        //config/filesystems local root setup public_path('images')
        $disk = Storage::disk('local');
        $disk->delete($image_name);
    }

    private function validate($input, $rules)
    {
        $validator = validator::make($input, $rules);
        if ($validator->fails()) {
            throw new \App\Exceptions\InvalidParameterException($validator->errors()->first());
            // return $validator->errors();
        }

        return true;
    }
}

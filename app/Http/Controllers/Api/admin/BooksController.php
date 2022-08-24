<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Books;
use App\Services\Admin\ProductServices;
use App\Services\Admin\ImageServices;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->productService = new ProductServices();
        $this->imageService = new ImageServices();
    }

    public function index()
    {
        $products = Books::all();
        return $this->response(200, 'data read success.', $products);
    }

    /**
     * 取得單一資料
     * 
     * @param int $id 
     * @return void
     */
    public function show($id)
    {
        try {
            $bookData = $this->productService->show($id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, 'data find success.', $bookData);
    }

    /**
     * 新增資料
     * @param Request $request
     * @return void 
     */
    public function store(Request $request)
    {
        //檢查有無圖片資料
        if (is_null($request->file('pic_file'))) {
            //這邊我不確定缺少資源的http code，先用404代替。
            return $this->response(404, 'need picture.');
        }

        //圖片資料沒問題，先上傳圖片並取得圖片名稱和路徑
        $imageData = $this->imageService->uploadImage($request->file('pic_file'));

        try {
            DB::beginTransaction();

            //先插入一般資料後取得產品id
            $product_id = $this->productService->create($request->input());

            //在儲存圖片文件到文件位置和圖片資料表中
            $this->productService->createPic($imageData, $product_id);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return $this->response(500, $e->getMessage());
        }

        return $this->response(201, 'data create success.');
    }

    /**
     * 更新資料
     * @param Request $request
     * @param int $id
     * @return void 
     */
    public function update(Request $request, $id)
    {
        //如果有更新圖片，就先上傳圖片
        if ($request->file('pic_file')) {
            try {
                DB::beginTransaction();
                //取得圖片名稱和路徑資料
                $imageData = $this->productService->uploadImage($request->file('pic_file'));

                //儲存圖片文件到文件位置和圖片資料表中
                $this->productService->updatePic($imageData, $id);
                DB::commit();
            } catch (\Throwable $e) {
                DB::rollBack();

                return $this->response(500, $e->getMessage());
            }
        }

        try {
            //更新資料
            $this->productService->update($request->input(), $id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        return $this->response(200, 'data update success.');
    }

    /**
     * 刪除資料
     * @param int @id
     * @return void
     */
    public function destroy($id)
    {
        try {
            $data = $this->imageService->showPic($id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        $temporary_image_name = $data['image_name'];

        // //先執行刪除一般資料
        try {
            DB::beginTransaction();

            $this->productService->delete($id);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->response(500, $e->getMessage());
        }

        // //刪除伺服器文件圖片資料
        $this->imageService->deletePicture($temporary_image_name);

        return $this->response(204, 'data delete success.');
    }

    private function response(int $code, $message, $data = [])
    {
        return response()->json([
            "status" => $code,
            "message" => $message,
            'data' => $data
        ]);
    }

    public function test()
    {
        // $post = Books::find(2)->sort;
        $post = Books::all();
        return $post;
    }
}

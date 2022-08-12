<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

use App\Books;
use App\Services\Admin\ProductServices;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->productService = new ProductServices();
    }

    public function index()
    {
        $products = Books::all();
        return $this->response(200, 'data read success.', $products);
    }

    public function show($id)
    {
        try {
            $bookData = $this->productService->show($id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, 'data find success.', $bookData);
    }

    public function store(Request $request)
    {
        if (is_null($request->file('pic_file'))) {
            //這邊我不確定缺少資源的http code，先用404代替。
            return $this->response(404, 'need picture.');
        }

        //圖片文件沒問題，就先上傳圖片
        $imageData = $this->productService->uploadImage($request->file('pic_file'));

        try {
            DB::beginTransaction();

            //先插入一般資料後取得table product_id
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

    public function update(Request $request, $id)
    {
        if ($request->file('pic_file')) {
            //如果有更新圖片，就先上傳圖片
            //這邊應該要寫個try catch之後再補
            $imageData = $this->productService->uploadImage($request->file('pic_file'));
            // dd($imageData['file_name']);
            $this->productService->updatePic($imageData, $id);
        }

        try {
            $this->productService->update($request->input(), $id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        return $this->response(200, 'data update success.');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $this->productService->delete($id);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->response(500, $e->getMessage());
        }

        return $this->response(204, 'data delete success.');
    }

    private function response(int $code, $message, $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
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

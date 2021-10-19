<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Message;

//使用者和管理員針對留言的CRUD API
class MessageController extends Controller
{
    //讀取產品留言，不過這個在內頁有做先跳過
    public function read(Request $request)
    { }

    //新增留言
    /**
     *  @return json $message
     */
    public function insert(Request $request)
    {
        //之後會有認證，先放著
        //將留言內容做字數上限制驗證??
        //controller 調度 Service 再到 Repository 先省略...
        //直接將數據insert data table

        //產品ID應該在前端的json 資料封包裡面

        //假設user_id 應該是要從session抓
        //所以會有user_id 的try catch

        return $request->input('content');

        // $user_id = 2;
        // $message = Message::create([
        //     'product_id'        =>  $product_id,
        //     'user_id'           =>  $user_id,
        //     'message_content'   =>  $request->input('content'),
        // ]);

        // return response()->json([
        //     'data'  =>  $message,
        // ]);
    }

    public function update(Request $request)
    { }
    public function delete(Request $request)
    { }
}

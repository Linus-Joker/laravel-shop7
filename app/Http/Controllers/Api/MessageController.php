<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Message;

//使用者和管理員針對留言的CRUD API
class MessageController extends Controller
{
    //讀取產品留言，不過這個在內頁有做先跳過
    public function read(Request $request)
    { }

    /**
     * 新增使用者留言
     *  @return json $message
     */
    public function insert(Request $request)
    {
        //之後會有認證，先放著
        //將留言內容做字數上限制驗證??
        //controller 調度 Service 再到 Repository 先省略...

        //產品ID應該在前端的json 資料封包裡面
        //假設有user_id 應該是要從session抓

        $class = 'App\Services\MessageService';
        $message = new $class;
        try {
            $data = [
                'product_id'        =>  $request->input('product_id'),
                'user_id'           =>  2,
                'message_content'   =>  $request->input('message_content'),
            ];
            DB::beginTransaction();

            $message->insert($data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->response(500, $e->getMessage());
        }

        return $this->response(201, '留言新增成功');
    }

    public function update(Request $request)
    { }
    public function delete(Request $request)
    { }

    private function response(int $code, $message, array $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function csrf()
    {
        $messageData = Message::find(13);

        return response()->json([
            'content'   => $messageData['message_content'],
        ]);
    }
}

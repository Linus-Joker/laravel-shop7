<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        //產品ID應該在前端的json 資料封包裡面
        //假設有user_id 應該是要從session抓
        $user_id = Session::has('userNumber') ? Session::get('userNumber') : null;
        if (is_null($user_id)) {
            return $this->response(440, "session Not exists.");
        }

        //呼叫要使用的物件
        $class = 'App\Services\MessageService';
        if (class_exists($class) === false) {
            return $this->response(422, 'class  ' . $class . '  Not exist.');
        }
        $message = new $class;

        try {
            //整理好需要的資料
            $data = [
                'product_id'        =>  $request->input('product_id'),
                'user_id'           =>  $user_id,
                'message_content'   =>  $request->input('message_content'),
            ];
            DB::beginTransaction();

            //插入資料
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

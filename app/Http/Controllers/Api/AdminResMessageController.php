<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class AdminResMessageController extends Controller
{
    /**
     * 新增管理員回覆留言
     * 
     * @param json {
     *      @var int $message_id 訊息編號
     *      @var string $res_content 管理員的回覆訊息
     * }
     * 
     * @return json 
     */
    public function insert(Request $request)
    {
        //一樣驗證資料後插入資料庫
        $admin_id = 1;

        try {
            $data = [
                'admin_id'      => $admin_id,
                'message_id'    => $request->input('message_id'),
                'res_content'   => $request->input('res_content'),
            ];

            DB::beginTransaction();

            DB::table('admin_res')->insert($data);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->response(500, $e->getMessage());
        }

        return $this->response(201, '管理員回覆留言新增成功');
    }

    private function response(int $code, $message, array $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}

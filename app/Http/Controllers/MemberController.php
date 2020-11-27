<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use PhpParser\Node\Stmt\TryCatch;

class MemberController extends Controller
{
    public function register(Request $request, $type)
    {
        // 依照傳進來的路徑來呼叫要使用的物件
        $class = 'App\Services\Account\Registration\\' . ucfirst($type);
        if (class_exists($class) === false) {
            return $this->response(422, 'class  ' . $class . '  Not exist.');
        }

        $account = new $class();
        // $memberId = $account->register($request->input());
        // return $memberId;

        try {
            //在這裡要先插入註冊會員資料，回傳插入後的id
            $memberId = $account->register($request->input());

            // 如果順利註冊，就取得啟用驗證碼
            $activateCode = $account->getActivateCode();

            // 寫入會員啟用資料表
            $account->activate($memberId, $activateCode);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, '會員註冊成功');
    }

    private function response(int $code, $message, array $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function login(Request $request)
    {
        $rules = [
            'account' => 'required',
        ];

        // $data = [
        //     'account' => 'milk',
        // ];

        $validator = validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        // return response()->json([
        //     'code' => 200,
        //     'message' => '會員註冊成功'
        // ]);

        return $this->response(200, '會員註冊成功');
    }
}

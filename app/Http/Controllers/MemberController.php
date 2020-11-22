<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function register(Request $request, $type)
    {
        // 依照傳進來的路徑來呼叫要使用的物件
        $class = 'App\Services\Account\Registration\\' . ucfirst($type);

        if (class_exists($class) === false) {
            $result = [
                'code'      => 422,
                'message'   => 'class  ' . $class . '  Not exist.',
            ];
            return response()->json($result);
        }

        $account = new $class;

        //在這裡要先插入註冊會員資料，回傳插入後的id
        $memberId = $account->register($request->input());

        // 如果順利註冊，就取得啟用驗證碼
        $activateCode = $account->getActivateCode();

        // 寫入會員啟用資料表
        $account->activate($memberId, $activateCode);

        $result = [
            'code' => 200,
            'message'   => 'registed success.'
        ];

        return response()->json($result);
    }
}

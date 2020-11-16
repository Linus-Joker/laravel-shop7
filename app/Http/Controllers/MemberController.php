<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return $account->register($request->input());

        // $memberId = $account->register($request->input());
    }
}

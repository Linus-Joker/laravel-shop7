<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin;
use App\Services\Admin\AdminServices;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->adminService = new AdminServices();
    }

    public function login(Request $request)
    {
        try {
            $adminData = $this->adminService->login($request->input());
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        // Session::put('adminNumber', $adminData['id']);
        return $this->response(200, '會員登入成功', $adminData);
    }

    public function changePassword(Request $request)
    {
        /**
         * 1.檢查有沒有登入
         * 2.檢查session 之類，現在登入的管理員是誰，
         * 並回傳admin_name and permission
         * 3.查看權限可否更改全部(之後要丟1個要更換誰的密碼)
         * 或自己的(只換自己的密碼)
         * if(per == 1){
         *      $admin_codename = 自己或是要換誰的
         * }else{
         *
         * $admin_codename = 自己的
         * }
         * 4.檢查驗證密碼格式有無正確(包含確認密碼)
         * 5.更換密碼
         * 6.完成-->返回Response
         **/
    }

    private function response(int $code, $message, $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}

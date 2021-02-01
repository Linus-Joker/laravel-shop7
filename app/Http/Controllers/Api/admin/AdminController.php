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
         * 是否有這管理員
         * 3.檢查驗證密碼格式有無正確(包含確認密碼)
         * 4.更換密碼
         * 5.完成-->返回Response
         **/
        try {
            $this->adminService->checkSession();

            $newPassword = $this->adminService->checkPassword($request->input());

            $id = 1;
            $this->adminService->changePassword($newPassword, $id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, 'password change success.');
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Services\Account\Registration\RegistrationFactory;
use App\Models\Member;

class MemberController extends Controller
{
    public function register(Request $request, $type)
    {
        // 依照傳進來的路徑來呼叫要使用的物件
        $account = RegistrationFactory::create($type);

        try {
            DB::beginTransaction();

            //在這裡要先插入註冊會員資料，回傳插入後的id
            $memberId = $account->register($request->input());

            // 如果順利註冊，就取得啟用驗證碼
            $activateCode = $account->getActivateCode();

            // 寫入會員啟用資料表
            $account->activate($memberId, $activateCode);

            DB::commit();
            /*
                之後傳驗證碼到視圖或者其他媒體，做信箱或手機驗證成功才返回註冊成功
            */
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, '會員註冊成功');
    }

    public function login(Request $request)
    {
        // 依照傳進來的類型來呼叫要使用的物件
        $value = request()->input('account');
        $fieldType = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'Email' : 'General';

        $class = 'App\Services\Account\Login\\' . $fieldType;

        if (class_exists($class) === false) {
            return $this->response(422, 'class  ' . $class . '  Not exist.');
        }

        $account = new $class;

        try {
            //進行登入檢查，成功就返回會員資料
            $memberData = $account->login($request->input());
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        // dd($memberData['id']);
        Session::put('userNumber', $memberData['id']);

        return $this->response(200, '會員登入成功', $memberData);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('userNumber');

        return redirect('/');
    }

    public function changePassword(Request $request)
    {
        //catch user session user_id
        $user_id = Session::has('userNumber') ? Session::get('userNumber') : null;

        if (is_null($user_id)) {
            return $this->response(440, 'user not exists, please login again.');
        }

        //呼叫會員物件
        $class = 'App\Services\Account\MemberService';

        if (class_exists($class) === false) {
            return $this->response(422, 'class  ' . $class . '  Not exist.');
        }

        $account = new $class;

        try {
            //整理傳來的資料
            $data = [
                'oldPassword'   => $request->input('oldPassword'),
                'newPassword'   => $request->input('newPassword'),
                'checkPassword' => $request->input('checkPassword'),
            ];

            $rules = [
                "oldPassword" => 'required|alpha_num|min:8|max:40',
                "newPassword" => 'required|alpha_num|min:8|max:40',
                "checkPassword" => 'required|alpha_num|min:8|max:40',
            ];

            //檢查並驗證資料格式
            $account->validate($data, $rules);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        //比對新密碼和確認密碼是否一致
        if ($data["newPassword"] !== $data["checkPassword"]) {
            return $this->response(422, 'password different');
        }

        try {
            //用 session user_id 找會員資料
            $memberData = $account->checkUserId($user_id);

            //檢查舊密碼和會員密碼是否一致，Hash後
            $userHashPassword = $memberData["password"];
            $account->checkPassword($data["oldPassword"], $userHashPassword);

            //更新密碼
            $account->changePassword($data["newPassword"], $user_id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(201, 'password change success.');
    }

    public function forgetPassword(Request $request)
    {
        //3.將字段密碼 hash 完存進 資料表
        //4.將未hash 字段密碼 寄送到信箱
        //呼叫會員物件
        $class = 'App\Services\Account\MemberService';

        if (class_exists($class) === false) {
            return $this->response(422, 'class  ' . $class . '  Not exist.');
        }

        $account = new $class;

        try {
            //整理傳來的資料
            $data = [
                'user_email'   => $request->input('user_email'),
            ];

            $rules = [
                "user_email" => 'required|email',
            ];

            //檢查並驗證資料格式
            $account->validate($data, $rules);

            //檢查使用者
            $memberData = $account->checkEmailAccountDB($request->input('user_email'));

            //得到暫時密碼
            $temporaryPassword = $account->getTemporaryPassword();

            //取得Hash後的暫時密碼
            // $hashTemporaryPassword = $account->hashPassword($temporaryPassword);

            $account->changePassword($temporaryPassword, $memberData['id']);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        //最後一部寄送為HASH的暫時密碼到使用者註冊的信箱()

        return $this->response(201, 'password send success.');
    }

    private function response(int $code, $message, array $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function getMember()
    {
        $user = DB::table('member')->get();
        return $user;
    }


    public function sessionCheck()
    {
        $userNumber = Session::has('userNumber') ? Session::get('userNumber') : null;
        return $userNumber;
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

use App\Services\Account\Registration\RegistrationFactory;

use PhpParser\Node\Stmt\TryCatch;

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

    private function response(int $code, $message, array $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('userNumber');

        return redirect('/');
    }

    public function hashTest(Request $request)
    {
        $hashPassword = Hash::make($request->input('password'), [
            'rounds' => 10
        ]);

        $member = new Member;

        $member::where('id', 1)->update(
            [
                'password' => $hashPassword
            ]
        );

        return $hashPassword;
    }

    public function hashCheckTest(Request $request)
    {
        $member = new Member;

        $dbPassword = $member::find(1)->password;

        if (Hash::check($request->input('password'), $dbPassword)) {
            return true;
        }

        return 'password error.';
    }

    public function sessionCheck()
    {
        $userNumber = Session::has('userNumber') ? Session::get('userNumber') : null;
        return $userNumber;
    }
}

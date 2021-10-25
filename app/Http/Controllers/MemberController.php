<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MemberController extends Controller
{
    public function login()
    {
        $user_id = Session::has('userNumber') ? Session::get('userNumber') : null;

        if ($user_id) {
            return redirect('/');
        }

        return view('login');
    }
}

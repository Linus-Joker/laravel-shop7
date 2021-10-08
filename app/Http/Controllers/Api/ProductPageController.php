<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductPageController extends Controller
{
    public function index()
    {
        $message = DB::table('message')
            ->join('admin_res', 'admin_res.message_id', '=', 'message.message_id')
            ->where('product_id', '=', 1)
            ->get();
        dd($message);
    }
}

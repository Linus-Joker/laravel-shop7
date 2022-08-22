<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;

use App\Cart;
use App\Orders;

use \ECPay_PaymentMethod as ECPayMethod;


class OrdersController extends Controller
{
    /**
     * getOrder是API，懶的分了，所以先做在這裡。
     */

    public function order()
    {
        //要有會員才可以進購物車
        //經購物車進到訂單頁面
        return view('order');
    }

    public function getOrder()
    {
        //要有會員才可以進購物車
        //經購物車進到訂單頁面
        //進頁面後才發起API向後端要資料
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        return view('order', [
            'products' => $cart->items,
            'totalPrice' => $cart->totalPrice,
            'totalQty' => $cart->totalQty
        ]);

        // return response()->json([
        //     'product' => $cart->items,
        //     'totalPrice' => $cart->totalPrice,
        //     'totalQty' => $cart->totalQty
        // ]);
    }

    public function store(Request $request)
    {
        /**
         * 1.驗證傳過來的資料
         * 2.製造uuid
         * 3.取得購物車Session
         * 4.插入資料到order tables
         * 5.開始串接ECPay
         */

        $class = 'App\Services\Orders\Payment\CreditCardPayment';

        $c = new $class();

        try {
            //驗證傳過來的資料
            $c->validate($request->input());

            //取得uuid
            $uuid_temp = $c->getUuid();
        } catch (\Throwable $e) {
            if ($e instanceof \App\Exceptions\InvalidParameterException) {
                return $this->response(422, $e->getMessage());
            }

            return $this->response(500, $e->getMessage());
        }


        //取得購物車Session
        $cart = session()->get('cart');
        if (is_null($cart)) {
            return $this->response(500, '購物車沒有資料。');
        }

        // return response()->json([
        //     'product' => $cart->items,
        //     'totalPrice' => $cart->totalPrice,
        //     'totalQty' => $cart->totalQty
        // ]);

        $orderData = [
            'name' => request('name'),
            'email' => request('email'),
            'cart' => serialize($cart),
            'uuid' => $uuid_temp
        ];

        //建立訂單資料到資料表
        // $order = Orders::create([
        //     'name' => request('name'),
        //     'email' => request('email'),
        //     'cart' => serialize($cart),
        //     'uuid' => $uuid_temp
        // ]);
        try {
            DB::beginTransaction();

            //建立訂單資料到資料表
            $c->createOrder($orderData);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            if ($e instanceof \App\Exceptions\InvalidParameterException) {
                return $this->response(422, $e->getMessage());
            }

            return $this->response(500, $e->getMessage());
        }

        try {
            $obj = new \ECPay_AllInOne();

            //服務參數
            $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";    //服務位置
            $obj->HashKey     = '5294y06JbISpM5x9';                                             //測試用Hashkey，請自行帶入ECPay提供的HashKey
            $obj->HashIV      = 'v77hoKGq4kWxNNIS';                                             //測試用HashIV，請自行帶入ECPay提供的HashIV
            $obj->MerchantID  = '2000132';                                                      //測試用MerchantID，請自行帶入ECPay提供的MerchantID
            $obj->EncryptType = '1';                                                            //CheckMacValue加密類型，請固定填入1，使用SHA256加密
            //基本參數(請依系統規劃自行調整)
            $MerchantTradeNo = $uuid_temp;
            $obj->Send['ReturnURL']             = "https://52daaa4ff10e.ngrok.io/laravel-shop7/public/callback";             //付款完成通知回傳的網址
            $obj->Send['PeriodReturnURL']       = "https://52daaa4ff10e.ngrok.io/laravel-shop7/public/callback";            //付款完成通知回傳的網址
            $obj->Send['ClientBackURL']         = "https://52daaa4ff10e.ngrok.io/laravel-shop7/public/success";             //付款完成通知回傳的網址
            $obj->Send['MerchantTradeNo']       = $MerchantTradeNo;                                 //訂單編號
            $obj->Send['MerchantTradeDate']     = date('Y/m/d H:i:s');                              //交易時間
            $obj->Send['TotalAmount']           = $cart->totalPrice;                                //交易金額
            $obj->Send['TradeDesc']             = "good to drink";                                  //交易描述
            $obj->Send['ChoosePayment']         = ECPayMethod::Credit;                              //付款方式:Credit
            $obj->Send['IgnorePayment']         = ECPayMethod::GooglePay;                           //不使用付款方式:GooglePay
            //訂單的商品資料
            array_push($obj->Send['Items'], array(
                'Name' => request('name'),
                'Price' => $cart->totalPrice,
                'Currency' => "元",
                'Quantity' => (int) "1",
                'URL' => "dedwed"
            ));
            session()->forget('cart');
            $obj->CheckOut();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback()
    {
        // dd(request());
        $order = Orders::where('uuid', '=', request('MerchantTradeNo'))->firstOrFail();
        $order->paid = !$order->paid;
        $order->save();
    }

    public function redirectFromECpay()
    {
        session()->flash('success', 'Order success!');
        return redirect('/');
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

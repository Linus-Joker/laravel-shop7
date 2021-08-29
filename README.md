# Laravel7 ShopCart Project Practice

try SOLID、Test、REST_api on shopCart Project

## Register

-   email Registered
-   general Registered 
-   3rd Registered (Building)

## Login

-   email Login
-   general Login
-   3rd Login (Building)

## Shop Cart

-   加入商品至購物車
-   查看購物車
-   在購物車增減數量 
-   到訂單頁面確認購買訂單
-   送出訂單結帳，串接EcPay Api (目前僅有信用卡結帳功能)

## Api
use Postman

-   註冊測試: POST /api/v1/member/registed/{type} 
(type:email or general)
###### need param:account、password、sex
 #### account:email or alphabet + number
 #### password:8~40 alphabet + number
 #### sex:1、2or3? (no problem!!)
---------------------------------------
-   登入測試:POST /api/v1/member/login (測試帳號:test01@example.com;密碼:password123)

## Admin

-   商品 CRUD for api

## Test

## Other

-   前端套件使用 Vue.js and Bootstrap4

## Remark

這個專案練習參考了 2 位前輩的範例，在此特別感謝 2 位前輩。

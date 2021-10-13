<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Books;

class ProductsRepository
{
    private $book;

    public function __construct()
    {
        $this->book = new Books();
    }

    /**
     * @param int $product_id 產品ID
     * @return array productData 
     */
    public function findOneProduct($product_id)
    {
        //1.先驗證
        //2.去資料表找
        //3.try catch
        //4.return

        $product = Books::find($product_id);

        return $product;
    }
}

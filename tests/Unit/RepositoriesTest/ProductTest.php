<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Books;

use App\Repositories\ProductsRepository;

class ProductTest extends TestCase
{
    //測試前後遷移資料表
    use RefreshDatabase;
    /**
     * search product 
     *
     * @return void
     */
    public function testSearchProduct()
    {
        $data = [
            'name'              =>  'book1',
            'description'       =>  'des1',
            'price'             =>  100,
            'products_sort_id'  =>  1,
        ];

        Books::insert($data);

        $product = new ProductsRepository();
        $productDate = $product->SearchProduct(1);

        $this->assertEquals(1, $productDate['id']);
        $this->assertEquals('book1', $productDate['name']);
        $this->assertEquals(100, $productDate['price']);
    }
}

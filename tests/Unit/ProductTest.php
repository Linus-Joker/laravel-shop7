<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use App\Repositories\ProductsRepository;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testProductPageShow()
    {
        $product = new ProductsRepository();
        $productDate = $product->findOneProduct(1);

        $this->assertEquals(1, $productDate['id']);
        $this->assertEquals('book1', $productDate['name']);
        $this->assertEquals(100, $productDate['price']);
    }
}

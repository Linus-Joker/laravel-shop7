<?php

use Illuminate\Database\Seeder;

use App\ProductSort;

class ProductsSortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductSort::create([
            'name'  => '書籍',
            'products_sort_details_id'  => 1
        ]);
    }
}

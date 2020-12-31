<?php

use Illuminate\Database\Seeder;

use App\ProductDetalis;

class ProductsDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductDetalis::create([
            'name'  => '電腦科學'
        ]);
    }
}

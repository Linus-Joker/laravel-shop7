<?php

use Illuminate\Database\Seeder;

use App\Books;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $price = 100;

        for ($i = 1; $i < 5; $i++) {
            Books::create([
                'name'  => 'book' . $i,
                'description'   => "It's des" . $i,
                'price'   => $i * $price
            ]);
        }
    }
}

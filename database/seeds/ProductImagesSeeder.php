<?php

use Illuminate\Database\Seeder;

use App\ProductImage;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'image_name' => 'PRODUCT-1.png',
                'image_path' => 'images',
                'products_id' => 1
            ],
            [
                'image_name' => 'PRODUCT-2.png',
                'image_path' => 'images',
                'products_id' => 2
            ],
            [
                'image_name' => 'PRODUCT-3.png',
                'image_path' => 'images',
                'products_id' => 3
            ],
        ];

        foreach ($products as $key => $value) {
            ProductImage::create($value);
        }
    }
}

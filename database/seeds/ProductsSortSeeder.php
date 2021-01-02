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
        $data = [
            [
                'name'  => '書籍',
                'products_sort_details'  => '電腦科學'
            ],
            [
                'name'  => '書籍',
                'products_sort_details'  => '商業理財'
            ]
        ];
        foreach ($data as $item) {
            ProductSort::create(
                [
                    'name'  => $item['name'],
                    'products_sort_details'  => $item['products_sort_details']
                ]
            );
        };
    }
}

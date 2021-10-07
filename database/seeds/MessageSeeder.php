<?php

use Illuminate\Database\Seeder;
use App\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productIdArray = [1, 1, 2, 1, 3, 2, 3];

        foreach ($productIdArray as $key => $value) {
            Message::create([
                'message_id'        => $key + 1,
                'product_id'        => $value,
                'user_id'           => $value,
                'message_content'   => 'hello message'
            ]);
        }
    }
}

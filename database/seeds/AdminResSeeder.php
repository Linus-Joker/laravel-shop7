<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminResSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 8; $i++) {
            DB::table('admin_res')->insert([
                'message_id'    => $i,
                'admin_id'      => 1,
                'res_content'   => 'OK!! '
            ]);
        }
    }
}

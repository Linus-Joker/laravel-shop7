<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'admin_name'    => 'admin001',
            'password'          => '19961231',
            'sex'               => 1,
            'status'            => 1,
            'permission'        => 1
        ]);

        Admin::create([
            'admin_name'    => 'admin002',
            'password'          => '19940101',
            'sex'               => 2,
            'status'            => 1,
            'permission'        => 2
        ]);
    }
}

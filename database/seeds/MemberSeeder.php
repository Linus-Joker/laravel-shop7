<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $data = [
            'reg_email' => 'test01@example.com',
            'password'  => Hash::make('password123', [
                'rounds' => 12
            ]),
            'sex'       => 1,
            'type'      => 1
        ];

        Member::create($data);
    }
}

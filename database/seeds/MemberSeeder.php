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
        for ($i = 1; $i < 4; $i++) {
            Member::create([
                'reg_email' => 'user' . $i . '@example.com',
                'user_name' => 'user' . $i,
                'password'  => Hash::make('password123', [
                    'rounds' => 12
                ]),
                'sex'       => 1,
                'type'      => 1
            ]);
        }
    }
}

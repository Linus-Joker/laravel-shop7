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
            'reg_email' => 'abc@mail.com',
            'password'  => Hash::make('12345678', [
                'rounds' => 12
            ]),
            'sex'       => 1,
            'type'      => 1
        ];

        Member::create($data);
    }
}

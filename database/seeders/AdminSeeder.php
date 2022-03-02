<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

    public function __construct()
    {
        $this->data = [
            [
                'full_name' => 'Admin',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('password'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    public function run()
    {
        foreach($this->data as $value)
        {
            if(!(DB::table('admins')->where('email', $value['email'])->first()))
            {
                DB::table('admins')->insert($value);
            }

        }
    }
}

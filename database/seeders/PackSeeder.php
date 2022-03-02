<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PackSeeder extends Seeder
{

    public function __construct()
    {
        $this->data = [
            [
                'title' => 'pack of 5',
                'quantity' => 5
            ],
            [
                'title' => 'pack of 10',
                'quantity' => 10
            ],
            [
                'title' => 'pack of 15',
                'quantity' => 15
            ],
            [
                'title' => 'pack of 30',
                'quantity' => 30
            ],
        ];
    }

    public function run()
    {
        foreach($this->data as $value)
        {
            if(!(DB::table('packs')->where('quantity', $value['quantity'])->first()))
            {
                DB::table('packs')->insert($value);
            }

        }
    }
}

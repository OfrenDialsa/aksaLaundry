<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    public function run()
    {
        $satuan = [
            'cuci' => ['baju' => 5000, 'celana' => 6000, 'jaket' => 8000, 'gaun' => 10000, 'sprey_kasur' => 12000],
            'setrika' => ['baju' => 3000, 'celana' => 4000, 'jaket' => 5000, 'gaun' => 6000, 'sprey_kasur' => 8000],
        ];

        foreach ($satuan as $category => $items) {
            foreach ($items as $item => $price) {
                DB::table('prices')->insert([
                    'type' => 'satuan',
                    'category' => $category,
                    'item' => $item,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $kiloan = [
            'cuci' => 16000,
            'setrika' => 12000
        ];

        foreach ($kiloan as $category => $price) {
            DB::table('prices')->insert([
                'type' => 'kiloan',
                'category' => $category,
                'item' => null,
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

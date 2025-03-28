<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Combo;

class ComboSeeder extends Seeder
{
    public function run(): void
    {
        Combo::insert([
            ['name' => 'Combo 1 (Bắp + Nước)', 'price' => 55000, 'image' => 'combo/combo1.jpg'],
            ['name' => 'Combo 2 (2 Bắp + 2 Nước)', 'price' => 99000, 'image' => 'combo/combo2.jpg'],
            ['name' => 'Combo Family (3 Bắp + 3 Nước)', 'price' => 139000, 'image' => 'combo/combo3.jpg'],
        ]);
    }
}

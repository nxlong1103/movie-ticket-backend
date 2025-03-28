<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Theater;

class TheaterSeeder extends Seeder
{
    public function run(): void
    {
        Theater::create(['name' => 'CGV Cinema', 'location' => 'Hà Nội', 'phone' => '0123456789']);
        Theater::create(['name' => 'Lotte Cinema', 'location' => 'TP.HCM', 'phone' => '0987654321']);
    }
}

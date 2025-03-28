<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Seat::create(['screen_id' => 2, 'seat_number' => "A$i", 'seat_type' => 'standard']);
        }
        for ($i = 1; $i <= 50; $i++) {
            Seat::create(['screen_id' => 3, 'seat_number' => "B$i", 'seat_type' => 'VIP']);
        }
    }
}

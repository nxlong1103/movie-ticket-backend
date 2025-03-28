<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        Booking::create(['user_id' => 1, 'showtime_id' => 1, 'total_price' => 300000, 'status' => 'paid']);
        Booking::create(['user_id' => 2, 'showtime_id' => 2, 'total_price' => 360000, 'status' => 'pending']);
    }
}


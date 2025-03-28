<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Showtime;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShowtimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('showtimes')->insert([
            [
                'movie_id' => 1, // ID của phim (Cần có sẵn trong bảng movies)
                'screen_id' => 2, // ID của phòng chiếu (Cần có sẵn trong bảng screens)
                'start_time' => Carbon::now()->addDays(1),
                'price' => 75000,
                'seat_count' => 100,
                'available_seats' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'movie_id' => 2,
                'screen_id' => 3,
                'start_time' => Carbon::now()->addDays(2),
                'price' => 90000,
                'seat_count' => 100,
                'available_seats' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

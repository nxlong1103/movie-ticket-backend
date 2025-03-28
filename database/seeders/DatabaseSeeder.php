<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,          // Đảm bảo có user trước
            MovieSeeder::class,         // Có phim
            TheaterSeeder::class,       // Có rạp
            ScreenSeeder::class,        // Có phòng chiếu
            ShowtimeSeeder::class,      // Có suất chiếu
            SeatSeeder::class,          // Có ghế ngồi
            BookingSeeder::class,       // Đặt vé trước khi thêm chi tiết
            BookingDetailSeeder::class, // Chạy sau BookingSeeder
            PaymentSeeder::class,
        ]);
    }
}

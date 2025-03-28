<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Seat;

class BookingDetailSeeder extends Seeder
{
    public function run(): void
    {
        // Kiểm tra xem có booking hay không
        $booking = Booking::first();
        $seat = Seat::first();

        if ($booking && $seat) {
            BookingDetail::create([
                'booking_id' => $booking->id,
                'seat_id' => $seat->id,
                'price' => 150000
            ]);
        }
    }
}



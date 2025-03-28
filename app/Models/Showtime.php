<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'screen_id',
        'start_time',
        'price',
        'seat_count',
        'available_seats'
    ];

    // Quan hệ với bảng Movies
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }
    // Quan hệ với bảng Screens (Phòng chiếu)
    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    // Quan hệ với đặt vé (Bookings)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Giảm số ghế trống khi có vé được đặt
    public function reduceAvailableSeats($quantity)
    {
        if ($this->available_seats >= $quantity) {
            $this->available_seats -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    // Tăng số ghế trống khi có vé bị hủy
    public function increaseAvailableSeats($quantity)
    {
        if ($this->available_seats + $quantity <= $this->seat_count) {
            $this->available_seats += $quantity;
            $this->save();
        }
    }
}

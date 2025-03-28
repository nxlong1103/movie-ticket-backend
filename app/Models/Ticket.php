<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'seat_id',
        'price',
        'payment_method',
        'transaction_id',
        'status',
        'qr_code',
        'booking_date'
    ];

    /**
     * Quan hệ: Mỗi vé thuộc về một người dùng
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ: Mỗi vé thuộc về một suất chiếu
     */
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    /**
     * Quan hệ: Mỗi vé thuộc về một ghế
     */
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    /**
     * Xác định xem vé đã được thanh toán chưa
     */
    public function isPaid()
    {
        return $this->status === 'paid';
    }

    /**
     * Tạo mã QR tự động nếu chưa có
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (!$ticket->qr_code) {
                $ticket->qr_code = 'QR_' . uniqid();
            }
        });
    }
}

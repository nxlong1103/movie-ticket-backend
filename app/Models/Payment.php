<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'status',
        'momo_order_id',
        'momo_trans_id',
        'momo_pay_url',
        'momo_result_code',
        'momo_message',
    ];

    // Liên kết với đơn đặt vé
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

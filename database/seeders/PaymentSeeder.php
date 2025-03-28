<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create(['booking_id' => 1, 'amount' => 300000, 'payment_method' => 'credit_card', 'status' => 'completed']);
    }
}


<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Người đặt vé
            $table->foreignId('showtime_id')->constrained()->onDelete('cascade'); // Suất chiếu
            $table->foreignId('seat_id')->constrained()->onDelete('cascade'); // Ghế ngồi
            $table->decimal('price', 10, 2); // Giá vé
            $table->enum('payment_method', ['cash', 'credit_card'])->default('cash'); // Phương thức thanh toán
            $table->string('transaction_id')->nullable(); // Mã giao dịch (nếu thanh toán online)
            $table->enum('status', ['booked', 'paid', 'cancelled', 'used'])->default('booked'); // Trạng thái vé
            $table->string('qr_code')->nullable(); // Mã QR để check-in
            $table->dateTime('booking_date'); // Ngày đặt vé
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};

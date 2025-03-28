<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade'); // Liên kết với phim
            $table->foreignId('screen_id')->constrained()->onDelete('cascade'); // Liên kết với phòng chiếu
            $table->dateTime('start_time'); // Thời gian bắt đầu chiếu
            $table->decimal('price', 10, 2); // Giá vé
            $table->integer('seat_count'); // Tổng số ghế có sẵn cho suất chiếu
            $table->integer('available_seats'); // Số ghế còn trống
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};

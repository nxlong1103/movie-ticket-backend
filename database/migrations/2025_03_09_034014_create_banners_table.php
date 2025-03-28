<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề banner
            $table->string('image'); // Đường dẫn ảnh banner
            $table->string('link')->nullable(); // Link khi nhấn vào banner
            $table->integer('position')->default(0); // Vị trí hiển thị
            $table->boolean('status')->default(1); // 1: Hiển thị, 0: Ẩn
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};

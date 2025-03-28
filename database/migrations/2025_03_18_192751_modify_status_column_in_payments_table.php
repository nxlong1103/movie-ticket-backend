<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Thay đổi độ dài cột 'status' trong bảng 'payments'
        Schema::table('payments', function (Blueprint $table) {
            // Cập nhật độ dài của cột 'status' thành 255 ký tự (hoặc số bạn cần)
            $table->string('status', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Khôi phục lại độ dài của cột 'status' nếu cần
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status', 100)->change(); // Giảm độ dài cột 'status' xuống 100 ký tự
        });
    }
};

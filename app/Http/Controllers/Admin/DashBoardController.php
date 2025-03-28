<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;

class DashBoardController extends Controller
{
    public function index()
    {
        // Kiểm tra dữ liệu có tồn tại không
        $movieCount = Movie::count();
        $showtimeCount = Showtime::count();
        $bookingCount = Booking::count();
        $paymentCount = Payment::count();
        $userCount = User::count(); // Đếm tổng số người dùng

        // Debug để kiểm tra dữ liệu (chạy 1 lần)
        // dd($movieCount, $showtimeCount, $bookingCount, $paymentCount, $userCount);

        // Trả về view với dữ liệu
        return view('admin.dashboard', compact(
            'movieCount', 'showtimeCount', 'bookingCount', 'paymentCount', 'userCount'
        ));
    }
}

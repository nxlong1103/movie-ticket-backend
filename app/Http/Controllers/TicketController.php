<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Showtime;
use App\Models\Movie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    // 📌 Hiển thị danh sách vé trên giao diện admin
    public function showTickets(Request $request)
    {
        $movies = Movie::all();
        $showtimes = Showtime::all();

        $query = Ticket::with(['user', 'showtime.movie']);

        // 📌 Lọc theo phim
        if ($request->has('movie_id') && $request->movie_id !== 'all') {
            $query->whereHas('showtime.movie', function ($q) use ($request) {
                $q->where('id', $request->movie_id);
            });
        }

        // 📌 Lọc theo suất chiếu
        if ($request->has('showtime_id') && $request->showtime_id !== 'all') {
            $query->where('showtime_id', $request->showtime_id);
        }

        // 📌 Lọc theo trạng thái vé
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 📌 Lọc theo ngày đặt vé
        if ($request->has('booking_date') && !empty($request->booking_date)) {
            $query->whereDate('booking_date', $request->booking_date);
        }

        // 📌 Phân trang danh sách vé
        $tickets = $query->paginate(10);

        return view('admin.tickets', compact('tickets', 'movies', 'showtimes'));
    }

    // 📌 Cập nhật trạng thái vé
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return redirect()->route('admin.tickets')->with('error', 'Không tìm thấy vé.');
        }

        $request->validate([
            'status' => 'required|in:Đã đặt,Đã sử dụng,Hủy'
        ]);

        $ticket->update(['status' => $request->status]);

        return redirect()->route('admin.tickets')->with('success', 'Cập nhật vé thành công!');
    }

    // 📌 Xóa vé (Chỉ xóa nếu trạng thái là Hủy, Đã sử dụng hoặc suất chiếu đã qua hơn 1 ngày)
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return redirect()->route('admin.tickets')->with('error', 'Không tìm thấy vé.');
        }

        $now = Carbon::now();
        $showtimeExpired = isset($ticket->showtime->start_time) && Carbon::parse($ticket->showtime->start_time)->lt(Carbon::now()->subDay());

        if ($ticket->status === 'Hủy' || $ticket->status === 'Đã sử dụng' || $showtimeExpired) {
            $ticket->delete();
            return redirect()->route('admin.tickets')->with('success', 'Vé đã được xóa!');
        }

        return redirect()->route('admin.tickets')->with('error', 'Không thể xóa vé vì chưa đến giờ suất chiếu hoặc chưa sử dụng.');
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'booking_date' => 'required|date',
            'status' => 'in:Đã đặt,Đã sử dụng,Hủy'
        ]);

        $ticket = Ticket::create($request->all());
        return response()->json($ticket, 201);
    }

    // Lấy thông tin một vé cụ thể
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'showtime'])->find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }
        return response()->json($ticket);
    }
}

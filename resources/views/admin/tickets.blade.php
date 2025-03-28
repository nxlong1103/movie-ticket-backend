<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Vé</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    @vite(['resources/css/admin/admin.css'])
</head>

<body>
    <div class="d-flex">
        @include('admin.layouts.admin_menu')

        <div class="main-content p-4">
            <h2 class="text-center fw-bold">🎟️ Quản Lý Vé</h2>
            <p class="text-center">Danh sách vé đã đặt.</p>

            <!-- Bộ lọc -->
            <form method="GET" action="{{ route('admin.tickets') }}" class="row g-3 mb-3">
                <div class="col-md-3">
                    <label><b>Chọn phim:</b></label>
                    <select name="movie_id" class="form-control">
                        <option value="all" {{ request('movie_id') == 'all' ? 'selected' : '' }}>Tất cả phim</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ request('movie_id') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label><b>Suất chiếu:</b></label>
                    <select name="showtime_id" class="form-control">
                        <option value="all" {{ request('showtime_id') == 'all' ? 'selected' : '' }}>Tất cả suất chiếu</option>
                        @foreach($showtimes as $showtime)
                            <option value="{{ $showtime->id }}" {{ request('showtime_id') == $showtime->id ? 'selected' : '' }}>
                                {{ $showtime->start_time }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label><b>Trạng thái:</b></label>
                    <select name="status" class="form-control">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả trạng thái</option>
                        <option value="Đã đặt" {{ request('status') == 'Đã đặt' ? 'selected' : '' }}>Đã đặt</option>
                        <option value="Đã sử dụng" {{ request('status') == 'Đã sử dụng' ? 'selected' : '' }}>Đã sử dụng</option>
                        <option value="Hủy" {{ request('status') == 'Hủy' ? 'selected' : '' }}>Hủy</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label><b>Ngày đặt vé:</b></label>
                    <input type="date" name="booking_date" class="form-control" value="{{ request('booking_date') }}">
                </div>

                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                </div>
            </form>

            <h4 class="mt-3">📊 Tổng vé đã đặt: <b>{{ $tickets->total() }}</b></h4>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã vé</th>
                            <th>Người dùng</th>
                            <th>Phim</th>
                            <th>Suất chiếu</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>
                                    @if(isset($ticket->user->name) && !empty($ticket->user->name))
                                        {{ $ticket->user->name }}
                                    @else
                                        <span style="color: red;">Chưa có thông tin</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($ticket->showtime->movie->title) && !empty($ticket->showtime->movie->title))
                                        {{ $ticket->showtime->movie->title }}
                                    @else
                                        <span style="color: red;">Không có dữ liệu</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if(isset($ticket->showtime->start_time) && !empty($ticket->showtime->start_time))
                                        {{ $ticket->showtime->start_time }}
                                    @else
                                        <span style="color: red;">Chưa có suất chiếu</span>
                                    @endif
                                </td>
                                
                                <td>{{ $ticket->booking_date }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                                        @csrf
                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                            <option value="Đã đặt" {{ $ticket->status == 'Đã đặt' ? 'selected' : '' }}>Đã đặt</option>
                                            <option value="Đã sử dụng" {{ $ticket->status == 'Đã sử dụng' ? 'selected' : '' }}>Đã sử dụng</option>
                                            <option value="Hủy" {{ $ticket->status == 'Hủy' ? 'selected' : '' }}>Hủy</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $showtimeExpired = isset($ticket->showtime->start_time) && \Carbon\Carbon::parse($ticket->showtime->start_time)->lt($now->subDay());
                                    $deletable = $ticket->status === 'Hủy' || $ticket->status === 'Đã sử dụng' || $showtimeExpired;
                                @endphp

                                @if($deletable)
                                    <form method="POST" action="{{ route('admin.tickets.destroy', $ticket->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-trash"></i> Không thể xóa
                                    </button>
                                @endif
                            </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Hiển thị phân trang -->
            <div class="d-flex justify-content-center">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</body>
</html>

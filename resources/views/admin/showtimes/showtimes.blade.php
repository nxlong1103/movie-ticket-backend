<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Suất Chiếu</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    @vite(['resources/css/admin/admin.css'])
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('admin.layouts.admin_menu') 

        <!-- Nội dung chính -->
        <div class="main-content p-4">
            <h2 class="text-center fw-bold">🎬 Quản Lý Suất Chiếu</h2>
            <p class="text-center">Danh sách suất chiếu trong hệ thống.</p>

            <!-- Form Lọc -->
            <form action="{{ route('admin.showtimes.showtimes') }}" method="GET" class="mb-3 d-flex align-items-end gap-3">
                <div class="form-group">
                    <label for="filter_movie">Chọn Phim:</label>
                    <select name="filter_movie" id="filter_movie" class="form-select">
                        <option value="">-- Tất cả --</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" {{ request('filter_movie') == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="filter_date">Chọn Ngày:</label>
                    <input type="date" name="filter_date" id="filter_date" class="form-control" value="{{ request('filter_date') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Lọc
                </button>
            </form>

            <!-- Nút thêm suất chiếu -->
            <a href="{{ route('admin.showtimes.addshowtime') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Thêm suất chiếu
            </a>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Phim</th>
                            <th>Phòng</th>
                            <th>Thời gian bắt đầu</th>
                            <th>Giá vé</th>
                            <th>Tổng ghế</th>
                            <th>Ghế trống</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($showtimes as $showtime)
                            <tr>
                                <td>{{ $showtime->movie->title }}</td>
                                <td>{{ $showtime->screen->name }}</td>
                                <td>{{ $showtime->start_time }}</td>
                                <td>{{ number_format($showtime->price) }} VND</td>
                                <td>{{ $showtime->seat_count }}</td>
                                <td>{{ $showtime->available_seats }}</td>
                                <td>
                                    <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>

                                    <!-- Nút xoá -->
                                    <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash"></i> Xoá
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener("click", function () {
                let confirmDelete = confirm("Bạn có chắc chắn muốn xoá suất chiếu này?");
                if (confirmDelete) {
                    this.closest("form").submit();
                }
            });
        });
    });
</script>

</html>

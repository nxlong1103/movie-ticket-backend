<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($showtime) ? 'Sửa Suất Chiếu' : 'Thêm Suất Chiếu' }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/admin/admin.css'])
</head>
<body>
    @include('admin.layouts.admin_menu') 
    <div class="main-content p-4">
        <div class="form-container">
            <h2 class="text-center fw-bold">🎬 {{ isset($showtime) ? 'Sửa Suất Chiếu' : 'Thêm Suất Chiếu' }}</h2>
            <hr>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ isset($showtime) ? route('admin.showtimes.update', $showtime->id) : route('admin.showtimes.store') }}" 
                method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($showtime))
                @method('PUT')
                @endif

                <!-- Chọn phim -->
                <div class="mb-3">
                    <label class="form-label">Chọn Phim</label>
                    <select name="movie_id" class="form-select" required>
                        <option value="">-- Chọn Phim --</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}" 
                                {{ isset($showtime) && $showtime->movie_id == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Chọn phòng chiếu -->
                <div class="mb-3">
                    <label class="form-label">Chọn Phòng Chiếu</label>
                    <select name="screen_id" class="form-select" required>
                        <option value="">-- Chọn Phòng --</option>
                        @foreach($screens as $screen)
                            <option value="{{ $screen->id }}" 
                                {{ isset($showtime) && $showtime->screen_id == $screen->id ? 'selected' : '' }}>
                                {{ $screen->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Thời gian chiếu -->
                <div class="mb-3">
                    <label class="form-label">Thời gian bắt đầu</label>
                    <input type="datetime-local" name="start_time" class="form-control" required
                           value="{{ isset($showtime) ? $showtime->start_time : '' }}">
                </div>

                <!-- Giá vé -->
                <div class="mb-3">
                    <label class="form-label">Giá vé (VND)</label>
                    <input type="number" name="price" class="form-control" min="0" required
                           value="{{ isset($showtime) ? $showtime->price : '' }}">
                </div>

                <!-- Tổng số ghế -->
                <div class="mb-3">
                    <label class="form-label">Tổng số ghế</label>
                    <input type="number" name="seat_count" class="form-control" min="1" required
                           value="{{ isset($showtime) ? $showtime->seat_count : '' }}">
                </div>

                <!-- Nút gửi -->
                <button type="submit" class="btn btn-primary w-100">
                    {{ isset($showtime) ? 'Cập Nhật' : 'Thêm Suất Chiếu' }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>

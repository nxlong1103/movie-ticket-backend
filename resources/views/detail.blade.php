<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $movie->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    @vite(['resources/css/detail.css'])
    @vite(['resources/css/style.css'])
    @vite(['resources/css/footer.css'])
    @vite(['resources/css/header.css'])
</head>
<body>
    @include('layouts.header')
    <div class="container main-container">
        <div class="container movie-detail-container">
            <div class="row g-4 align-items-start">
                <!-- Poster -->
                <div class="col-md-6 col-12 text-center">
                    <img src="{{ asset('images/' . $movie->image) }}" class="movie-poster img-fluid" alt="{{ $movie->title }}">
                </div>
        
                <!-- Thông tin -->
                <div class="col-md-6 col-12 movie-info">
                    <h1>{{ $movie->title }}</h1>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-clock"></i> Thời lượng: {{ $movie->duration }} phút</li>
                        <li><i class="fas fa-globe"></i> Quốc gia: VN</li>
                        <li><i class="fas fa-calendar-alt"></i> Khởi chiếu: {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</li>
                        <li><i class="fas fa-star"></i> Đánh giá: {{ $movie->rating }}/10</li>
                        <li><i class="fas fa-user-shield"></i> Phân loại: T16 - Phim dành cho khán giả từ đủ 16 tuổi trở lên</li>
                    </ul>
        
                    <div class="mb-3">
                        <a href="{{ $movie->trailer_url }}" target="_blank" class="btn btn-trailer">
                            🎬 Xem Trailer
                        </a>
                    </div>
                    
        
                    <div class="movie-description">
                        <h5 class="mb-2 text-warning">Mô tả</h5>
                        <p>{{ $movie->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Form đặt vé -->
        <form action="{{ route('select_seats') }}" method="GET" class="booking-form mt-5">
            <h5><i class="fas fa-ticket-alt text-warning"></i> Đặt vé ngay</h5>
        
            <div id="error-message" class="alert alert-danger d-none">
                Vui lòng chọn đầy đủ Rạp, Ngày và Suất chiếu trước khi tiếp tục!
            </div>
            
        
            <div class="row g-4 align-items-center justify-content-between">
                <!-- Chọn rạp -->
                <div class="col-md-3 col-12">
                    <label class="form-label"><i class="fas fa-film text-info"></i> Chọn rạp</label>
                    <select name="theater_id" class="form-select" required>
                        <option selected disabled>-- Chọn rạp --</option>
                        @foreach ($theaters as $theater)
                            <option value="{{ $theater->id }}">{{ $theater->name }}</option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Gạch nối -->
                <div class="col-md-1 divider-col d-none d-md-flex">
                    <div class="divider-line"></div>
                </div>
        
                <!-- Chọn ngày -->
                <div class="col-md-3 col-12">
                    <label class="form-label"><i class="fas fa-calendar-day text-info"></i> Chọn ngày</label>
                    <select name="date" class="form-select" required>
                        <option selected disabled>-- Chọn ngày --</option>
                        @foreach ($showtimes->map(fn($s) => \Carbon\Carbon::parse($s->start_time)->format('Y-m-d'))->unique() as $date)
                            <option value="{{ $date }}">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Gạch nối -->
                <div class="col-md-1 divider-col d-none d-md-flex">
                    <div class="divider-line"></div>
                </div>
        
                <!-- Chọn suất chiếu -->
                <div class="col-md-3 col-12">
                    <label class="form-label"><i class="fas fa-clock text-info"></i> Chọn suất chiếu</label>
                    <select name="showtime_id" class="form-select" required>
                        <option selected disabled>-- Chọn suất chiếu --</option>
                        @foreach ($showtimes as $showtime)
                            <option value="{{ $showtime->id }}">{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-arrow-right"></i> Tiếp tục
                </button>
            </div>
        </form>
        
    </div>
    </div>

    @include('layouts.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   
    
</body>
@vite(['resources/js/detail.js'])
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($movie) ? 'Sửa Phim' : 'Thêm Phim Mới' }}</title>

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
            <h2 class="text-center fw-bold">🎬 {{ isset($movie) ? 'Sửa Phim' : 'Thêm Phim Mới' }}</h2>
            <hr>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ isset($movie) ? route('admin.movies.update', $movie->id) : route('admin.movies.store') }}" 
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($movie))
                    @method('PUT')
                @endif

                <!-- Tiêu đề -->
                <div class="mb-3">
                    <label class="form-label">Tiêu đề phim</label>
                    <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" required
                           value="{{ isset($movie) ? $movie->title : '' }}">
                </div>

                <!-- Mô tả -->
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Nhập mô tả" required>{{ isset($movie) ? $movie->description : '' }}</textarea>
                </div>

                <!-- Thời gian -->
                <div class="mb-3">
                    <label class="form-label">Thời lượng (phút)</label>
                    <input type="number" name="duration" class="form-control" min="1" required
                           value="{{ isset($movie) ? $movie->duration : '' }}">
                </div>

                <!-- Ngày phát hành -->
                <div class="mb-3">
                    <label class="form-label">Ngày phát hành</label>
                    <input type="date" name="release_date" class="form-control" required
                           value="{{ isset($movie) ? $movie->release_date : '' }}">
                </div>

                <!-- Đánh giá -->
                <div class="mb-3">
                    <label class="form-label">Đánh giá (0 - 10)</label>
                    <input type="number" name="rating" class="form-control" step="0.1" min="0" max="10" required
                           value="{{ isset($movie) ? $movie->rating : '' }}">
                </div>

                <!-- Trạng thái -->
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select" required>
                        <option value="1" {{ isset($movie) && $movie->status == 1 ? 'selected' : '' }}>Phim đang chiếu</option>
                        <option value="2" {{ isset($movie) && $movie->status == 2 ? 'selected' : '' }}>Phim sắp chiếu</option>
                    </select>
                </div>

                <!-- Ảnh -->
                <div class="mb-3">
                    <label class="form-label">Ảnh phim</label>
                    <input type="file" name="image" class="form-control">
                    @if(isset($movie) && $movie->image)
                        <img src="{{ asset('images/' . $movie->image) }}" class="img-thumbnail mt-2" width="150">
                    @endif
                </div>

                <!-- Trailer -->
                <div class="mb-3">
                    <label class="form-label">Link Trailer</label>
                    <input type="text" name="trailer_url" class="form-control" placeholder="Nhập link trailer (nếu có)"
                           value="{{ isset($movie) ? $movie->trailer_url : '' }}">
                </div>

                <!-- Nút gửi -->
                <button type="submit" class="btn btn-primary w-100">{{ isset($movie) ? 'Cập Nhật' : 'Thêm Phim' }}</button>
            </form>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Phim</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    @vite(['resources/css/admin/admin.css'])
</head>
    <style>
    </style>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('admin.layouts.admin_menu') 

        <!-- Nội dung chính -->
        <div class="main-content p-4">
            <h2 class="text-center fw-bold">🎬 Quản Lý Phim</h2>
            <p class="text-center">Danh sách phim đang chiếu.</p>

            <!-- ComboBox chọn trạng thái phim -->
            <form method="GET" action="{{ route('admin.movies.movies') }}" class="mb-3">
                <label for="status" class="fw-bold">Lọc phim:</label>
                <select name="status" id="status" class="form-select w-25 d-inline-block"
                        onchange="this.form.submit()">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Tất cả</option>
                    <option value="1" {{ $status == 1 ? 'selected' : '' }}>Phim đang chiếu</option>
                    <option value="2" {{ $status == 2 ? 'selected' : '' }}>Phim sắp chiếu</option>
                </select>
            </form>

            <div class="table-responsive">
                <table class="table table-dark table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Hình ảnh</th> 
                            <th>Tiêu đề</th>
                            <th>Mô tả</th>
                            <th>Ngày phát hành</th>
                            <th>Thời gian</th>
                            <th>Đánh giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movies as $movie)
                            <tr>
                                <td>
                                    <img src="{{ asset('images/' . $movie->image) }}" alt="{{ $movie->title }}" class="img-thumbnail">
                                </td>
                                <td>{{ $movie->title }}</td>
                                <td>{{ Str::limit($movie->description, 50) }}</td>
                                <td>{{ $movie->release_date }}</td>
                                <td>{{ $movie->duration }} phút</td>
                                <td>⭐ {{ $movie->rating }}</td>
                                <td>
                                    <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
        
                                    <!-- Nút xoá -->
                                    <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" class="d-inline delete-form">
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
                let confirmDelete = confirm("Bạn có chắc chắn muốn xoá phim này?");
                if (confirmDelete) {
                    this.closest("form").submit();
                }
            });
        });
    });
</script>
</html>

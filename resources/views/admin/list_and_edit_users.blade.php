<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    @vite(['resources/css/admin/admin.css'])
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('admin.layouts.admin_menu')

        <!-- Nội dung chính -->
        <div class="main-content p-4">
            <h2 class="text-center fw-bold">👤 Quản Lý Người Dùng</h2>

            <!-- Thông báo thành công hoặc lỗi -->
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" id="error-alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Bảng danh sách người dùng -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số Điện Thoại</th>
                            <th>Ngày Sinh</th>
                            <th>Vai Trò</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ \Carbon\Carbon::parse($user->dob)->format('Y-m-d') }}</td>
                                <td>
                                    @if ($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-primary">User</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- Nút sửa -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>

                                    <!-- Nút xóa -->
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal sửa thông tin người dùng -->
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT') <!-- Chỉ định phương thức PUT cho update -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editUserModalLabel">Chỉnh Sửa Người Dùng</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Tên Người Dùng</label>
                                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Số Điện Thoại</label>
                                                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dob" class="form-label">Ngày Sinh</label>
                                                    <input type="date" class="form-control" name="dob" value="{{ \Carbon\Carbon::parse($user->dob)->format('Y-m-d') }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Vai Trò</label>
                                                    <select class="form-select" name="role" required>
                                                        <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                                        <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript để ẩn thông báo sau 2 giây -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const successAlert = document.getElementById('success-alert');
                const errorAlert = document.getElementById('error-alert');
                if (successAlert) successAlert.style.display = 'none';
                if (errorAlert) errorAlert.style.display = 'none';
            }, 2000);
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

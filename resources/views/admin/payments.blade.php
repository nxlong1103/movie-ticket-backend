<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Thanh Toán</title>

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
            <h2 class="text-center fw-bold">💳 Quản Lý Thanh Toán</h2>
            <p class="text-center">Danh sách các giao dịch thanh toán.</p>

            <!-- Hiển thị thông báo -->
            @if(session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" id="error-alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Bộ lọc -->
            <form method="GET" action="{{ route('admin.payments') }}" class="row g-3 mb-3 filter-form">
                <div class="col-md-4">
                    <label><b>Phương thức thanh toán:</b></label>
                    <select name="payment_method" class="form-control">
                        <option value="all" {{ request('payment_method') == 'all' ? 'selected' : '' }}>Tất cả</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tiền mặt</option>
                        <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Thẻ tín dụng</option>
                        <option value="momo" {{ request('payment_method') == 'momo' ? 'selected' : '' }}>Momo</option>
                        <option value="zalopay" {{ request('payment_method') == 'zalopay' ? 'selected' : '' }}>ZaloPay</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label><b>Trạng thái:</b></label>
                    <select name="status" class="form-control">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label><b>Ngày thanh toán:</b></label>
                    <input type="date" name="payment_date" class="form-control" value="{{ request('payment_date') }}">
                </div>

                <div class="col-md-12 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                </div>
            </form>

            <h4 class="mt-3">📊 Tổng thanh toán: <b>{{ $payments->total() }}</b></h4>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Phương thức</th>
                            <th>Số tiền</th>
                            <th>Ngày thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($payment->payment_method) }}</span>
                                </td>
                                <td class="text-success fw-bold">{{ number_format($payment->amount, 0, ',', '.') }} VND</td>
                                <td>{{ $payment->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}">
                                        @csrf
                                        <select name="status" class="form-control status-select" onchange="this.form.submit()">
                                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                            <option value="completed" {{ $payment->status == 'completed' ? 'selected' : '' }}>Đã thanh toán</option>
                                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Thất bại</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <!-- Xóa thanh toán không cần điều kiện -->
                                    <form method="POST" action="{{ route('admin.payments.destroy', $payment->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Hiển thị phân trang -->
            <div class="d-flex justify-content-center">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    <script>
        // Ẩn thông báo sau 2 giây
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 2000); // 2 giây

        // Giữ lại giá trị đã chọn trong select
        document.addEventListener("DOMContentLoaded", function () {
            const selects = document.querySelectorAll(".filter-form select");
            selects.forEach(select => {
                const selectedValue = select.getAttribute("data-selected");
                if (selectedValue) {
                    select.value = selectedValue;
                }
            });
        });
    </script>
</body>
</html>

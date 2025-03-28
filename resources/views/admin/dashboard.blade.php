<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng Quan Admin</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    @vite(['resources/css/admin/admin.css'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background-color: #343a40; /* Màu nền tối */
            color: #ffffff; /* Màu chữ sáng */
        }
        h5{
            font-size: 1.5rem;
            padding :10px;
        }
        .card {
            border-radius: 10px;
            transition: transform 0.3s;
            background-color: #495057; /* Màu nền tối cho card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9); /* Đổ bóng cho card */
            animation: float 3s ease-in-out infinite; /* Hiệu ứng di chuyển */
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .fs-1 {
            font-size: 3rem;
        }
        .chart-container {
            display: flex;
            justify-content: center; /* Căn giữa theo chiều ngang */
            align-items: center; /* Căn giữa theo chiều dọc */
            margin: 20px auto; /* Tự động căn giữa và tạo khoảng cách trên/dưới */
            height: 50vh; /* Chiều cao 50% viewport */
            width: 100%; /* Chiều rộng 80% màn hình */
            background-color: #495057; /* Màu nền tối */
            border-radius: 10px; /* Bo góc */
            padding: 20px; /* Khoảng cách bên trong */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.9); /* Đổ bóng */
        }

        .header-title {
            color: #ffffff; /* Màu chữ sáng */
        }
        .header-subtitle {
            color: #adb5bd; /* Màu chữ nhạt hơn */
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('admin.layouts.admin_menu') 

        <!-- Nội dung chính -->
        <div class="main-content p-4">
            <h2 class="text-center header-title fw-bold" style="font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
                Quản Lý 
            </h2>
            <p class="text-center header-subtitle" style="font-size: 1.2rem; color: #bdc3c7;">
                Trang tổng quản lý dành cho Admin.
            </p>
            <hr style="border-top: 2px solid #ffffff; width: 50%; margin: 20px auto;"/>
        

            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3 text-center">
                        <i class="fas fa-film fs-1 text-warning"></i>
                        <h5>Phim</h5>
                        <p><span>{{ $movieCount }}</span> phim</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3 text-center">
                        <i class="fas fa-clock fs-1 text-warning"></i>
                        <h5>Suất chiếu</h5>
                        <p><span>{{ $showtimeCount }}</span> suất</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3 text-center">
                        <i class="fas fa-ticket-alt fs-1 text-warning"></i>
                        <h5>Đặt vé</h5>
                        <p><span>{{ $bookingCount }}</span> lượt đặt vé</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3 text-center">
                        <i class="fas fa-money-bill-wave fs-1 text-warning"></i>
                        <h5>Thanh toán</h5>
                        <p><span>{{ $paymentCount }}</span> giao dịch</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3 text-center">
                        <i class="fas fa-users fs-1 text-warning"></i>
                        <h5>Người dùng</h5>
                        <p><span>{{ $userCount }}</span> khách hàng</p>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ cột -->
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar', // Loại biểu đồ
            data: {
                labels: ['Phim', 'Suất Chiếu', 'Đặt Vé', 'Thanh Toán', 'Người Dùng'],
                datasets: [{
                    label: 'Số lượng',
                    data: [{{ $movieCount }}, {{ $showtimeCount }}, {{ $bookingCount }}, {{ $paymentCount }}, {{ $userCount }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)', // Màu cho cột Phim
                        'rgba(153, 102, 255, 0.8)', // Màu cho cột Suất Chiếu
                        'rgba(255, 159, 64, 0.8)', // Màu cho cột Đặt Vé
                        'rgba(255, 99, 132, 0.8)', // Màu cho cột Thanh Toán
                        'rgba(54, 162, 235, 0.8)' // Màu cho cột Người Dùng
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)', // Đường viền cho cột Phim
                        'rgba(153, 102, 255, 1)', // Đường viền cho cột Suất Chiếu
                        'rgba(255, 159, 64, 1)', // Đường viền cho cột Đặt Vé
                        'rgba(255, 99, 132, 1)', // Đường viền cho cột Thanh Toán
                        'rgba(54, 162, 235, 1)' // Đường viền cho cột Người Dùng
                    ],
                    borderWidth: 2 // Độ dày đường viền
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: {
                                size: 14, // Kích thước phông chữ cho nhãn
                                family: 'Arial', // Phông chữ
                                weight: 'bold' // Độ đậm
                            },
                            color: '#ffffff' // Màu chữ cho nhãn
                        }
                    },
                    tooltip: {
                        backgroundColor: '#495057', // Màu nền tooltip
                        titleColor: '#ffffff', // Màu chữ tiêu đề tooltip
                        bodyColor: '#ffffff', // Màu chữ nội dung tooltip
                        borderColor: '#ccc', // Màu viền tooltip
                        borderWidth: 1 // Độ dày viền tooltip
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ffffff', // Màu chữ cho trục y
                            font: {
                                size: 12 // Kích thước phông chữ cho trục y
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ffffff', // Màu chữ cho trục x
                            font: {
                                size: 12 // Kích thước phông chữ cho trục x
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
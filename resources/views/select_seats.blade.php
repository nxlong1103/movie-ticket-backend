<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn Ghế - Hệ Thống Bán Vé Xem Phim</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS Custom -->
    @vite(['resources/css/style.css'])
    @vite(['resources/css/footer.css'])
    @vite(['resources/css/header.css'])
    @vite(['resources/css/seats.css'])
</head>
<body>
@include('layouts.header')

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="text-center text-warning mb-5">
                🎟️ Chọn Ghế Cho Phim
            </h2>
    
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-film me-2 text-warning"></i>Phim</h5>
                        <p>{{ $movie->title }}</p>
                    </div>
                </div>
    
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-calendar-alt me-2 text-warning"></i>Ngày</h5>
                        <p>{{ date('d-m-Y', strtotime($date)) }}</p>
                    </div>
                </div>
    
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-building me-2 text-warning"></i>Rạp</h5>
                        <p>{{ $theater->name }}</p>
                    </div>
                </div>
    
                <div class="col-md-6">
                    <div class="info-card">
                        <h5><i class="fas fa-clock me-2 text-warning"></i>Suất</h5>
                        <p>{{ date('H:i', strtotime($showtime->start_time)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ✅ GẠCH NGANG PHÂN CÁCH -->
    <hr class="my-5 border-top border-warning" style="opacity: 0.5;">
    <!-- Form bọc ghế + combo -->
    <form action="{{ url('/confirm-seats') }}" method="POST">
        @csrf
        <input type="hidden" name="theater_id" value="{{ $theater_id }}">
        <input type="hidden" name="movie_id" value="{{ $movie_id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="showtime_id" value="{{ $showtime_id }}">
        <input type="hidden" name="total_amount" id="totalAmountInput">

        <!-- Màn hình -->
        <div class="screen-wrapper text-center mt-4">
            <div class="screen">MÀN HÌNH</div>
        </div>
    
        <!-- Sơ đồ ghế -->
        <div class="seat-map text-center mt-4">
            <h4 class="text-white mb-3">Sơ Đồ Ghế</h4>
    
            @php
                $groupedSeats = collect($seats)->sortBy('seat_number')->groupBy(fn($s) => substr($s->seat_number, 0, 1));
            @endphp
    
            @foreach ($groupedSeats as $row => $seatsInRow)
                <div class="seat-row mb-2 d-flex justify-content-center align-items-center">
                    <span class="row-label me-2">{{ $row }}</span>
                    @foreach ($seatsInRow->sortBy(fn($s) => intval(substr($s->seat_number, 1))) as $seat)
                        <label class="seat-label {{ $seat->seat_type === 'VIP' ? 'vip-seat' : '' }}">
                            <input type="checkbox" name="seats[]" value="{{ $seat->seat_number }}">
                            <span>{{ $seat->seat_number }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>
    
        <!-- Chú thích -->
        <div class="text-center mt-3 text-white">
            <span class="badge bg-light text-dark">Ghế Thường</span>
            <span class="badge bg-warning text-dark ms-2">Ghế VIP</span>
            <span class="badge bg-success text-white ms-2">Đã chọn</span>
        </div>
        
        <div class="container mt-5">
            <h3 class="text-center text-white mb-4">🍿 CHỌN BẮP NƯỚC</h3>
            <div class="row justify-content-center">
                @foreach ($combos as $combo)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card text-center h-100">
                            <img src="{{ asset('images/' . $combo->image) }}" class="card-img-top" style="height: 150px; object-fit: contain;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $combo->name }}</h5>
                                <p class="card-text">{{ number_format($combo->price, 0, ',', '.') }}đ</p>
                                <div class="combo-counter">
                                    <button type="button" onclick="updateCombo('{{ $combo->id }}', -1)">−</button>
                                    <input type="number" name="combo[{{ $combo->id }}]" id="combo-{{ $combo->id }}" value="0" readonly>
                                    <button type="button" onclick="updateCombo('{{ $combo->id }}', 1)">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
   
       <!-- Box Tổng tiền + nút -->
        <div class="checkout-box text-center mt-5 mb-5 d-flex justify-content-between align-items-center px-4 py-3">
            <h5 class="text-white mb-0">Tổng tiền: <span id="totalAmount">0đ</span></h5>
            <button type="submit" id="submitButton" class="btn btn-warning px-4 py-2 fw-bold shadow" disabled>Tiếp tục</button>
        </div>

    </form>
    
</main>

@include('layouts.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const seatCheckboxes = document.querySelectorAll('input[name="seats[]"]');
        const comboInputs = document.querySelectorAll('input[type="number"][name^="combo"]');
        const totalAmountEl = document.getElementById('totalAmount');
        const submitButton = document.getElementById("submitButton");

        // Danh sách giá ghế (server render)
        const seatPrices = @json($seats->pluck('price', 'seat_number'));

        // Cập nhật tổng tiền
        function updateTotal() {
            let total = 0;

            // Tính tiền ghế
            seatCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const seatNumber = checkbox.value;
                    const price = parseInt(seatPrices[seatNumber] || 0);
                    total += price;
                }
            });

            // Tính tiền combo
            comboInputs.forEach(input => {
                const quantity = parseInt(input.value) || 0;
                const priceText = input.closest('.card-body').querySelector('.card-text').innerText;
                const price = parseInt(priceText.replace(/[^\d]/g, '')) || 0;
                total += price * quantity;
            });

            // Hiển thị tổng tiền
            totalAmountEl.textContent = total.toLocaleString('vi-VN') + 'đ';
            document.getElementById('totalAmountInput').value = total;
            // Bật nút nếu có ghế được chọn
            const anySeatSelected = [...seatCheckboxes].some(cb => cb.checked);
            submitButton.disabled = !anySeatSelected;
        }

        // Thay đổi số lượng combo
        function updateCombo(id, delta) {
            const input = document.getElementById('combo-' + id);
            let current = parseInt(input.value) || 0;
            current = Math.max(0, current + delta);
            input.value = current;
            updateTotal();
        }

        // Gán hàm updateCombo vào window để dùng trong HTML
        window.updateCombo = updateCombo;

        // Gán sự kiện cho checkbox ghế
        seatCheckboxes.forEach(cb => cb.addEventListener('change', updateTotal));

        // Gán sự kiện cho nút combo (nút - và + đã gán trong HTML gọi updateCombo)
        updateTotal(); // Khởi tạo
    });
</script>

</body>
</html>

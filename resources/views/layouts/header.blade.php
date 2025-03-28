<header class="header-container">
    <div class="header-top">
        <!-- Logo -->
        <div class="header-logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/banner/logo.jpg') }}" alt="Logo">
            </a>
        </div>

        <!-- Nút đặt vé -->
        <div class="header-buttons">
            <button class="btn btn-yellow">🎟️ ĐẶT VÉ NGAY</button>
            <button class="btn btn-purple">🍿 ĐẶT BẮP NƯỚC</button>
        </div>

        <!-- Ô tìm kiếm -->
        <div class="search-container">
            <input type="text" class="search-bar" placeholder="Tìm phim, rạp">
            <span class="search-icon">🔍</span>
        </div>

        <!-- Tài khoản & ngôn ngữ -->
        <div class="header-account">
            @auth
                <span class="icon">👤 {{ Auth::user()->name }}</span>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
        
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-sm">
                    Đăng xuất
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light">👤 Đăng nhập</a>
            @endauth
        </div>
        
        
    </div>

    <!-- Menu dưới -->
    <nav class="header-menu">
        <a href="#" class="nav-link">📍 Chọn rạp</a>
        <a href="#" class="nav-link">📍 Lịch chiếu</a>
        <a href="#" class="nav-link">Khuyến mãi</a>
        <a href="#" class="nav-link">Thuê sự kiện</a>
        <a href="#" class="nav-link">Tất cả các giải trí</a>
        <a href="#" class="nav-link">Giới thiệu</a>
    </nav>
</header>

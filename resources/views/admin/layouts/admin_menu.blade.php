<nav class="sidebar bg-dark text-white p-3">
    <div class="text-center mb-3">
        <img src="{{ asset('images/banner/logo.jpg') }}" alt="Logo" class="img-fluid" style="max-width: 100%; height:150px;">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>

        <!-- Dropdown menu QUẢN LÝ PHIM -->
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center"
               href="#" data-bs-toggle="collapse" data-bs-target="#movieMenu">
                <i class="fas fa-film"></i>Quản lý Phim Ảnh
                <i class="fas fa-chevron-down"></i>  <!-- Biểu tượng mũi tên -->
            </a>
            <ul class="collapse list-unstyled ps-3" id="movieMenu">
                <li><a class="nav-link text-white" href="{{ route('admin.movies.addmovies') }}"><i class="fas fa-plus-circle"></i> Thêm Phim</a></li>
                <li><a class="nav-link text-white" href="{{ route('admin.movies.movies') }}"><i class="fas fa-list"></i> Danh Sách Phim</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center"
               href="#" data-bs-toggle="collapse" data-bs-target="#showtimeMenu">
                <i class="fas fa-clock"></i> Quản lý Suất Chiếu  
                <i class="fas fa-chevron-down"></i>  <!-- Biểu tượng mũi tên -->
            </a>
            <ul class="collapse list-unstyled ps-3" id="showtimeMenu">
                <li><a class="nav-link text-white" href="{{ route('admin.showtimes.addshowtime') }}"><i class="fas fa-plus-circle"></i> Thêm Suất Chiếu</a></li>
                <li><a class="nav-link text-white" href="{{ route('admin.showtimes.showtimes') }}"><i class="fas fa-list"></i> Danh Sách Suất Chiếu</a></li>
            </ul>
        </li>
        
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.tickets') }}">
                <i class="fas fa-ticket-alt"></i> Quản lý Vé Bán
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.payments') }}">
                <i class="fas fa-credit-card"></i> Quản lý Thanh Toán
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex justify-content-between align-items-center"
               href="#" data-bs-toggle="collapse" data-bs-target="#userMenu">
               <i class="fas fa-users"></i> Quản lý Người Dùng 
                <i class="fas fa-chevron-down"></i>
            </a>
            <ul class="collapse list-unstyled ps-3" id="userMenu">
                <li><a class="nav-link text-white" href="{{ route('admin.users.create') }}">Thêm Người Dùng</a></li>
                <li><a class="nav-link text-white" href="{{ route('admin.users') }}">Danh Sách Người Dùng</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.reports') }}">
                <i class="fas fa-chart-line"></i> Báo Cáo Doanh Thu
            </a>
        </li>
    </ul>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

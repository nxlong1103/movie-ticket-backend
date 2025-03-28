<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    @vite(['resources/css/login.css'])
</head>
<body>

    <div class="login-container">
        <!-- Tab chuyển Đăng nhập / Đăng ký -->
        <div class="nav-tabs">
            <a href="{{ url('/login') }}">ĐĂNG NHẬP</a>
            <a href="{{ url('/register') }}" class="active">ĐĂNG KÝ</a>
        </div>

        <h2>Đăng Ký</h2>

        <form method="POST" action="{{ url('/register') }}">
            @csrf
            <input type="text" name="name" placeholder="Họ và Tên *" required>
            <input type="email" name="email" placeholder="Email *" required>
            <input type="password" name="password" placeholder="Mật khẩu *" required>
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu *" required>
            
            <button type="submit">ĐĂNG KÝ</button>
        </form>
    </div>

</body>
</html>

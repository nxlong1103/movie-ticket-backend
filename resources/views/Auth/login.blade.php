<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite(['resources/css/login.css'])
    
</head>

<body>
 
    
    <div class="login-container">
        <!-- Tab chuyển Đăng nhập / Đăng ký -->
        <div class="nav-tabs">
            <a href="{{ url('/login') }}" class="active">ĐĂNG NHẬP</a>
            <a href="{{ url('/register') }}">ĐĂNG KÝ</a>
        </div>

        <h2>Đăng Nhập</h2>

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <input type="email" name="email" placeholder="Tài khoản, Email hoặc số điện thoại *" required>
            <input type="password" name="password" placeholder="Mật khẩu *" required>
            
            <div class="remember-me">
                <input type="checkbox" name="remember"> Lưu mật khẩu đăng nhập
            </div>

            <button type="submit">ĐĂNG NHẬP</button>
        </form>

        <div class="forgot-password">
            <a href="#">Quên mật khẩu?</a>
        </div>
        <a href="{{ route('auth.google') }}" class="btn btn-danger">
            <i class="fab fa-google"></i> Đăng nhập với Google
        </a>
    </div>
    
   
    
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
 
</html>

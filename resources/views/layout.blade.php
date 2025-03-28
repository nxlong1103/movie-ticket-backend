<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang chủ')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Hệ thống bán vé xem phim</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2025 - Bản quyền thuộc về bạn</p>
    </footer>
</body>
</html>

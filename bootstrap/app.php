<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up', // Kiểm tra trạng thái ứng dụng
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Thay thế middleware trong Laravel 12 (Không còn trong App\Http\Middleware)
        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class, // Middleware xác thực user
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Middleware xác thực email
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Middleware giới hạn request
        ]);

        // Middleware cho nhóm `web`
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class, // Mã hóa cookie
            \Illuminate\Session\Middleware\StartSession::class, // Bắt đầu session
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Chia sẻ lỗi từ session
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Hỗ trợ route binding
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // ✅ Middleware CSRF cho web
        ]);

        // Middleware cho nhóm `api`
   
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        // Xử lý lỗi toàn cục
        $exceptions->reportable(function (Throwable $e) {
            logger()->error($e->getMessage());
        });

        // Trả về JSON khi không tìm thấy tài nguyên
        $exceptions->renderable(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            return response()->json(['error' => 'Resource not found'], 404);
        });

        // Trả về JSON khi route không tồn tại
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return response()->json(['error' => 'Page not found'], 404);
        });
    })
    ->create();

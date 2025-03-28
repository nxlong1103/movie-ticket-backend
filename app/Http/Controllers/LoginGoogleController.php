<?php
  
  namespace App\Http\Controllers;
  
  use Illuminate\Http\Request;
  use Laravel\Socialite\Facades\Socialite;
  use Exception;
  use App\Models\User;
  use Illuminate\Support\Facades\Auth;
    
  class LoginGoogleController extends Controller
  {
      /**
       * Điều hướng người dùng đến trang đăng nhập Google
       */
      public function redirectToGoogle()
      {
          return Socialite::driver('google')->redirect();
      }
          
      /**
       * Xử lý phản hồi từ Google
       */
      public function handleGoogleCallback()
      {
          try {
              // Lấy thông tin user từ Google
              $googleUser = Socialite::driver('google')->user();
  
              // Kiểm tra xem user đã tồn tại chưa (theo email hoặc google_id)
              $user = User::where('google_id', $googleUser->id)
                          ->orWhere('email', $googleUser->email)
                          ->first();
  
              if (!$user) {
                  // Nếu chưa có user, tạo mới và mặc định role là 'user'
                  $user = User::create([
                      'name' => $googleUser->name,
                      'email' => $googleUser->email,
                      'google_id' => $googleUser->id,
                      'password' => bcrypt('random_password'), // Không cần mật khẩu khi đăng nhập bằng Google
                      'role' => 'user' // Mặc định là user
                  ]);
              }
  
              // Đăng nhập vào hệ thống
              Auth::login($user);
  
              // Chuyển hướng về trang home
              return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
  
          } catch (Exception $e) {
              return redirect()->route('login')->with('error', 'Có lỗi xảy ra khi đăng nhập bằng Google.');
          }
      }
  }
  
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Chào mừng Admin!');
            } else {
                return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
            }
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng']);
    }
    public function store(Request $request)
    {
        // Validate và login...
        $request->authenticate();
        $request->session()->regenerate();

        // ✅ Redirect đúng trang người dùng định vào
        return redirect()->intended('/');
    }

    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('Auth.register');
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công, hãy đăng nhập!');
    }

    // Xử lý đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}

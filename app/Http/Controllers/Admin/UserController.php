<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 📌 Hiển thị danh sách người dùng
    public function list(Request $request)
    {
        $users = User::query();

        // Lọc người dùng theo các tham số
        if ($request->filled('role') && $request->role != 'all') {
            $users->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $users->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Phân trang danh sách người dùng
        $users = $users->paginate(10);
        return view('admin.list_and_edit_users', compact('users'));
    }

    // 📌 Hiển thị form tạo người dùng
    public function create()
    {
        return view('admin.create_user');
    }

    // 📌 Lưu người dùng mới
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone'    => 'required|string|max:15',
            'dob'      => 'required|date',
            'role'     => 'required|in:user,admin',
        ]);

        try {
            DB::beginTransaction();

            // Tạo người dùng mới
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'phone'    => $request->phone,
                'dob'      => $request->dob,
                'role'     => $request->role,
            ]);

            DB::commit();
            return redirect()->route('admin.users.list')->with('success', 'Thêm người dùng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // 📌 Hiển thị form sửa thông tin người dùng
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.users.list')->with('error', 'Người dùng không tồn tại.');
        }

        return view('admin.users.edit', compact('user'));
    }

    // 📌 Cập nhật thông tin người dùng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'phone'    => 'required|string|max:15',
            'dob'      => 'required|date',
            'role'     => 'required|in:user,admin',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
    
        try {
            DB::beginTransaction();
    
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('admin.users.list')->with('error', 'Người dùng không tồn tại.');
            }
    
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'dob'   => $request->dob,
                'role'  => $request->role,
            ]);
    
            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
    
            DB::commit();
            return redirect()->route('admin.users.list')->with('success', 'Cập nhật người dùng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.list')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
    

    // 📌 Xóa người dùng
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return redirect()->route('admin.users.list')->with('error', 'Người dùng không tồn tại.');
            }

            // Xóa người dùng
            $user->delete();
            return redirect()->route('admin.users.list')->with('success', 'Người dùng đã bị xóa.');
        } catch (\Exception $e) {
            return redirect()->route('admin.users.list')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}



// class UserController extends Controller
// {
//     // 📌 Hiển thị form thêm người dùng
//     public function index(Request $request)
//     {
//         return view('admin.create_user'); // Hiển thị form tạo người dùng
//     }

//     // 📌 Hiển thị form thêm người dùng
//     public function create()
//     {
//         return view('admin.create_user'); // Trả về form tạo người dùng
//     }

//     // 📌 Lưu người dùng mới
//     public function store(Request $request)
//     {
//         // Validate dữ liệu
//         $request->validate([
//             'name'     => 'required|string|max:255',
//             'email'    => 'required|email|unique:users,email',
//             'password' => 'required|string|min:6|confirmed',
//             'phone'    => 'required|string|max:15',
//             'dob'      => 'required|date',
//             'role'     => 'required|in:user,admin',
//         ]);

//         try {
//             DB::beginTransaction();

//             $user = User::create([
//                 'name'     => $request->name,
//                 'email'    => $request->email,
//                 'password' => Hash::make($request->password),
//                 'phone'    => $request->phone,
//                 'dob'      => $request->dob,
//                 'role'     => $request->role,
//             ]);

//             DB::commit();
//             return redirect()->route('admin.users')->with('success', 'Thêm người dùng thành công!');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
//         }
//     }

//     // 📌 Hiển thị form sửa thông tin người dùng
//     public function edit($id)
//     {
//         $user = User::find($id);
//         if (!$user) {
//             return redirect()->route('admin.users')->with('error', 'Người dùng không tồn tại.');
//         }

//         return view('admin.users.edit', compact('user'));
//     }

//     // 📌 Cập nhật thông tin người dùng
//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'name'     => 'required|string|max:255',
//             'email'    => 'required|email|unique:users,email,' . $id,
//             'phone'    => 'required|string|max:15',
//             'dob'      => 'required|date',
//             'role'     => 'required|in:user,admin',
//             'password' => 'nullable|string|min:6|confirmed',
//         ]);

//         try {
//             DB::beginTransaction();

//             $user = User::find($id);
//             if (!$user) {
//                 return redirect()->route('admin.users')->with('error', 'Người dùng không tồn tại.');
//             }

//             $user->update([
//                 'name'  => $request->name,
//                 'email' => $request->email,
//                 'phone' => $request->phone,
//                 'dob'   => $request->dob,
//                 'role'  => $request->role,
//             ]);

//             if ($request->filled('password')) {
//                 $user->update([
//                     'password' => Hash::make($request->password),
//                 ]);
//             }

//             DB::commit();
//             return redirect()->route('admin.users')->with('success', 'Cập nhật người dùng thành công!');
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
//         }
//     }

//     // 📌 Xóa người dùng
//     public function destroy($id)
//     {
//         try {
//             $user = User::find($id);
//             if (!$user) {
//                 return redirect()->route('admin.users')->with('error', 'Người dùng không tồn tại.');
//             }

//             $user->delete();
//             return redirect()->route('admin.users')->with('success', 'Người dùng đã bị xóa.');
//         } catch (\Exception $e) {
//             return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
//         }
//     }

    
// }

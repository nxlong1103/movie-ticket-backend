<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Banner;
use App\Models\Theater;
use App\Models\Showtime;

class MovieController extends Controller
{
    public function allMovies()
    {
        return response()->json(['movies' => Movie::all()]);
    }
    // Hiển thị trang chủ với danh sách phim
    public function index()
    {
        try {
            $movies = Movie::where('status', 1)->latest()->get();
            $upcomingMovies = Movie::where('status', 2)->latest()->get();
            $banners = Banner::where('status', 1)->orderBy('position', 'asc')->get();
            $theaters = Theater::all();
            $showtimes = Showtime::all();

            return view('home', compact('movies', 'upcomingMovies', 'banners', 'theaters', 'showtimes'));
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage());
        }
    }

    // app/Http/Controllers/MovieController.php

    public function showMovie(Request $request)
    {
        $status = $request->input('status', 'all'); // Lấy trạng thái từ request, mặc định là 'all'

        $query = Movie::orderBy('release_date', 'desc');

        // Kiểm tra nếu status không phải 'all' thì lọc theo status
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $movies = $query->get(); // Lấy danh sách phim sau khi lọc

        return view('admin.movies.movies', compact('movies', 'status'));
    }
    // Hiển thị form thêm phim mới
    public function create()
    {
        return view('admin.movies.addmovies'); // ✅ Đảm bảo view tồn tại
    }


    // Lưu phim mới vào database
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'duration' => 'required|integer|min:1',
                'release_date' => 'required|date',
                'rating' => 'required|numeric|min:0|max:10',
                'status' => 'required|in:1,2',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'trailer_url' => 'nullable|string|max:255'
            ]);

            $data = $request->all();

            // Xử lý upload ảnh nếu có
            if ($request->hasFile('image')) {
                $imageName = 'movies/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/movies'), $imageName);
                $data['image'] = $imageName;
            }

            Movie::create($data);

            return redirect()->route('admin.movies.movies')->with('success', 'Phim đã được thêm thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi thêm phim: ' . $e->getMessage());
        }
    }

    // Hiển thị chi tiết một phim
    // public function show($id)
    // {
    //     $movie = Movie::findOrFail($id);
    //     return view('movies.movies.show', compact('movie'));
    // }
    public function show($id)
    {
        // Lấy thông tin phim
        $movie = Movie::findOrFail($id);

        // Lấy tất cả suất chiếu của phim
        $showtimes = Showtime::where('movie_id', $id)
            ->orderBy('start_time')
            ->get();

        // Lấy toàn bộ rạp để hiển thị trong select
        $theaters = Theater::all();

        // Trả về view detail.blade.php với dữ liệu
        return view('detail', compact('movie', 'showtimes', 'theaters'));
    }
    // Hiển thị form chỉnh sửa phim
    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('admin.movies.addmovies', compact('movie'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required',
                'duration' => 'required|integer|min:1',
                'release_date' => 'required|date',
                'rating' => 'required|numeric|min:0|max:10',
                'status' => 'required|in:1,2',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'trailer_url' => 'nullable|string|max:255'
            ]);

            $movie = Movie::findOrFail($id);
            $data = $request->all();

            // Xử lý upload ảnh mới nếu có
            if ($request->hasFile('image')) {
                $imageName = 'movies/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/movies'), $imageName);
                $data['image'] = $imageName;
            }

            $movie->update($data);

            return redirect()->route('admin.movies.movies')->with('success', 'Phim đã được cập nhật.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi cập nhật phim: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);

        // Xóa file ảnh nếu có
        if ($movie->image && file_exists(public_path('images/' . $movie->image))) {
            unlink(public_path('images/' . $movie->image));
        }

        $movie->delete();

        return redirect()->route('admin.movies.movies')->with('success', 'Phim đã bị xoá.');
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;

class TheaterController extends Controller
{
    public function index() {
        $theaters = Theater::all(); // Lấy tất cả rạp từ database
        return view('cinema.index', compact('theaters'));
    }

    public function store(Request $request)
    {
        $theater = Theater::create($request->all());
        return response()->json($theater, 201);
    }

    public function show($id)
    {
        return response()->json(Theater::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $theater = Theater::findOrFail($id);
        $theater->update($request->all());
        return response()->json($theater, 200);
    }

    public function destroy($id)
    {
        Theater::destroy($id);
        return response()->json(['message' => 'Theater deleted'], 200);
    }
}

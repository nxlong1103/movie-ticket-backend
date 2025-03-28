<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screen;

class ScreenController extends Controller
{
    public function index()
    {
        return response()->json(Screen::all(), 200);
    }

    public function store(Request $request)
    {
        $screen = Screen::create($request->all());
        return response()->json($screen, 201);
    }

    public function show($id)
    {
        return response()->json(Screen::findOrFail($id), 200);
    }

    public function update(Request $request, $id)
    {
        $screen = Screen::findOrFail($id);
        $screen->update($request->all());
        return response()->json($screen, 200);
    }

    public function destroy($id)
    {
        Screen::destroy($id);
        return response()->json(['message' => 'Screen deleted'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theater;

class FooterController extends Controller
{
    public function footerData()
    {
        $theaters = Theater::all(); // Lấy danh sách rạp từ database
        return view('layouts.footer', compact('theaters'));
    }
}

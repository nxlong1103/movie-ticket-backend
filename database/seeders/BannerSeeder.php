<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        Banner::create([
            'title' => 'Phim Bom Tấn 2025',
            'image' => 'banner1.jpg',
            'link' => 'http://127.0.0.1:8000/home',
            'position' => 1,
            'status' => 1
        ]);

        Banner::create([
            'title' => 'Khuyến Mãi Đặc Biệt',
            'image' => 'banner2.jpg',
            'link' => 'http://127.0.0.1:8000/home',
            'position' => 2,
            'status' => 1
        ]);
    }
}

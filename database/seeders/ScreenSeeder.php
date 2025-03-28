<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Screen;

class ScreenSeeder extends Seeder
{
    public function run(): void
    {
        Screen::create(['theater_id' => 1, 'name' => 'Screen 1', 'seat_count' => 100]);
        Screen::create(['theater_id' => 2, 'name' => 'Screen 2', 'seat_count' => 150]);
    }
}

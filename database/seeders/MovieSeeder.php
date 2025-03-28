<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        Movie::create([
            'title' => 'Quỷ Nhập Tràng',
            'description' => 'Lấy cảm hứng từ câu chuyện có thật.',
            'duration' => 120,
            'release_date' => '2025-03-07',
            'rating' => '9.8',
            'image' => 'movies/quy_nhap_trang.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=quynhaptrang'
        ]);

        Movie::create([
            'title' => 'Nhà Gia Tiến',
            'description' => 'Một bộ phim của Huỳnh Lập.',
            'duration' => 110,
            'release_date' => '2025-02-21',
            'rating' => '9.8',
            'image' => 'movies/nha_gia_tien.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=nhagiatien'
        ]);
        Movie::create([
            'title' => 'Lạc Trôi Flow',
            'description' => 'Một bộ phim hoạt hình đề cử Oscars.',
            'duration' => 90,
            'release_date' => '2025-03-07',
            'rating' => '7.5',
            'image' => 'movies/lac_troi_flow.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=lactroiflow'
        ]);
        Movie::create([
            'title' => 'Mobile Suit Gundam: Kỷ Nguyên Mới',
            'description' => 'Gundam trở lại với cuộc chiến mới.',
            'duration' => 130,
            'release_date' => '2025-03-07',
            'rating' => '8.5',
            'image' => 'movies/gundam_ky_nguyen_moi.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=gundamkynguyenmoi'
        ]);
        Movie::create([
            'title' => 'Sát Thủ Vô Cùng Cực Hài',
            'description' => 'Vitamin cười tràn rạp sớm.',
            'duration' => 120,
            'release_date' => '2025-03-14',
            'rating' => '8',
            'image' => 'movies/sat_thu_vo_cung_cuc_hai.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=satthuvocungcuchai'
        ]);
        Movie::create([
            'title' => 'Cưới Ma: Hiến Mẹ Cho Quỷ',
            'description' => 'Kinh dị Indonesia trở lại màn ảnh rộng.',
            'duration' => 100,
            'release_date' => '2025-02-28',
            'rating' => '8.5',
            'image' => 'movies/cuoi_ma.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=cuoima'
        ]);
        Movie::create([
            'title' => 'Emma và Vương Quốc Tí Hon',
            'description' => 'Một cô bé giữa thế giới bao la.',
            'duration' => 95,
            'release_date' => '2025-03-07',
            'rating' => '8',
            'image' => 'movies/emma_vuong_quoc_ti_hon.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=emma'
        ]);
        Movie::create([
            'title' => 'Nụ Hôn Bạc Tỷ',
            'description' => 'Hài hước, tình cảm và cảm động.',
            'duration' => 105,
            'release_date' => '2025-01-29',
            'rating' => '8.9',
            'image' => 'movies/nu_hon_bac_ty.jpg',
            'trailer_url' => 'https://www.youtube.com/watch?v=nuhonbacty'
        ]);
    }
}

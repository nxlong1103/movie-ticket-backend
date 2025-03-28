<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'duration', 'release_date', 'rating', 'image', 'trailer_url', 'status'];


    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

}


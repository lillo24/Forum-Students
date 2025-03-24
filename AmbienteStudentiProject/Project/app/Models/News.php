<?php

namespace App\Models;

use App\Models\NewsImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $table = "NEWSTABLE";
    protected $fillable = [
        'title',
        'description',
        'photo',
    ];
    public function newsImages()
    {
        return $this->hasMany(NewsImage::class);
    }
}

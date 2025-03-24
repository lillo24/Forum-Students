<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{
    use HasFactory;
    protected $table = "NEWSIMAGESTABLE";
    protected $fillable = [
        'file_path',
        'news_id',
    ];
    public $timestamps = false;
}

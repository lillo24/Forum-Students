<?php

namespace App\Http\Controllers;

use App\Models\NewsImage;
use Illuminate\Http\Request;

class NewsImagesController extends Controller
{
    static public function upload($path, $newsId){

        $images = new NewsImage;

        $images->file_path = $path;
        $images->news_id = $newsId;

        $images->save();

        return response()->json([true]);
    }
}

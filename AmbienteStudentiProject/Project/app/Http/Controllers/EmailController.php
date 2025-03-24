<?php

namespace App\Http\Controllers;

use App\Mail\errorMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function reportError(Request $request){
        Mail::to('leonardo.colli04@gmail.com')->send(new errorMail($request['description']));
    }
}

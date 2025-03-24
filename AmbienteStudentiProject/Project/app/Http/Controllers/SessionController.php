<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    public function set(Request $request){
        $request = $request->post();
        foreach($request as $key => $value){
            Session::put($key, $value);
        }
    }
}

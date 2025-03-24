<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function callBackFromGoogle()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Check User Email If Already There
            $is_user = User::where('email', $user->getEmail())->first();

            if(!$is_user){

                // Check if it is a Berto's mail

                $email = $user->getEmail();
                $isBertoEmail = preg_match('/liceoberto.it/', $email);
                $isStudent = preg_match('/\d/', $email);
                if($isBertoEmail AND $isStudent){
                    $saveUser = User::updateOrCreate(
                    [
                        'google_id' => $user->getId(),
                    ],
                    [
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                    ]);
                    $saveUser = User::where('email', $user->getEmail())->first();
                }else{
                    return redirect()->route('auth' , 'errorLogin')->with(['error' => 'notStudent']);
                }
            }else{
                $saveUser = User::where('email',  $user->getEmail())->update([
                    'google_id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                ]);
                $saveUser = User::where('email', $user->getEmail())->first();
            }
            Auth::login($saveUser);
            return redirect()->route('saveCredPage');
        } catch (\Throwable $th) {
            return redirect()->route('errorPage' , 'errorLogin');
        }
    }
    public function saveCred($yes){
        Auth::login(Auth::user());
    }
    public function logout(){

        $user = Auth::user();
        $user->update(['remember_token' => NULL]);

        Session::flush();
        
        Auth::logout();

        return redirect()->route('auth');
    }
}

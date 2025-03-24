<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
    
        $user->student_level = 5;
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->google_id = 'currentlyNull';
        
        $user->save();

        return 'stored';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json([true]);
    }
    
    //Change student_level from admin.php
    
    public function changeLevel($id, $level){
        $user = User::find($id);
        if(is_numeric($level)){
            $user->update(['student_level' => $level]);
        }else{
            $user->update(['student_level' => 0]);
        }

    }
    
    //First Login

    public function firstLogin(){

        $user = User::find(Auth::id());
        $user->update(['logged_before' => 1]);
        
        $user = User::find(Auth::id());
        
        return response()->json($user);
    }
}

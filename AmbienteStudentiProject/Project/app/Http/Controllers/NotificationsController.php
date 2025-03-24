<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
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
    static public function store($type, $user_id, $data)
    {
        $notification = new Notification();

        $notification->type = $type;
        $notification->user_id = $user_id;

        if($type == 'report'){
            $notification->report_id = $data['report_id'];
        }
        if($type == 'comment'){
            $notification->comment_id = $data['comment_id'];
            if(isset($data['comment_referred_id'])){
                $notification->comment_referred_id = $data['comment_referred_id'];
            }
        }

        $notification->save();

    }

    static public function seen()
    {
        $notificationsSeen = Notification::where('user_id', Auth::id());
        $notificationsSeen->update(['seen' => 1]);
    }

    public function report()
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

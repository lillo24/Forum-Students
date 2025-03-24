<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Comment;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationsController;

class ReportsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $report = new Report();
    
        $report->report_text = $request['report_text'];
        $report->user_id = Auth::id();

        if(isSet($request['proposal_reported'])){
            $user_reported_id = Proposal::find($request['proposal_reported'])['user_id'];
            $report->user_reported_id = $user_reported_id;
        }else{
            $user_reported_id = Comment::find($request['comment_reported'])['user_id'];
            $report->user_reported_id = $user_reported_id;
        }

        $report->save();

        $data = [];
        $data['report_id'] = $report['id'];
        
        NotificationsController::store('report', $user_reported_id, $data);

        return 'done';
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
        //
    }
}

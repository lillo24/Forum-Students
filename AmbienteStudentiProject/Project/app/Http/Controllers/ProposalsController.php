<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request,[
            'proposal_title' => 'required',
            'proposal_text' => 'required'
            ]);
        if(!$user->activeProposal()->exists()){
            $proposal = new Proposal();
    
            $proposal->proposal_title = $request['proposal_title'];
            $proposal->proposal_text = $request['proposal_text'];
            $proposal->user_id = $user['id'];

            $proposal->save();
            
            return response()->json([$proposal]);
        }else{
            $proposal = Proposal::where('active', 1)->where('user_id' , Auth::id());
            $proposal->update(['proposal_title' => $request['proposal_title']]);
            $proposal->update(['proposal_text' => $request['proposal_text']]); 
            return response()->json([true]);
        }
        
        return  response()->json(true);
    }

    /**
     * Flag the proposal
    */
    public function flag($id)
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
        Proposal::destroy($id);
        return response()->json([true]);
    }

    // Destroy own proposal

    public function destroyMine()
    {
        Proposal::destroy(Proposal::where('user_id', Auth::id())->get()[0]['id']);
        return response()->json([true]);
    }
}

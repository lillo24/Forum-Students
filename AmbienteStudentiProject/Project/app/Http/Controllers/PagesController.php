<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\News;
use App\Models\User;
use App\Models\Config;
use App\Models\Comment;
use App\Models\Proposal;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{

    //Auth page

    public function auth(){
        if(Auth::check()){
            $level = Auth::user()['student_level'];
            if($level == 2 Or $level == 1 Or $level == 0){
                return redirect()->route('main');
            }else{
                return redirect()->route('admin');
            }
        }
        return view('login/auth');
    }
    public function saveCred(){
        return view('login/saveCred');
    }

    //Weeks
    public function main(Request $request){
        $whichWeek = Config::first();
        if(Auth::user()['email'] == 'colli.leonardo04@liceoberto.it'){
                $proposals=Proposal::all()->where('active', '1');
                return view('weeks/fifthweek', [
                    'proposals' => $proposals,
                ]);
        }
        switch ($whichWeek['week']) {
            case 1:
                $user = Auth::user();
                $proposal = false;
                if($user->activeProposal()->exists()){
                    $proposal = $user->activeProposal()->get();
                    $proposal = $proposal[0];
                }
                return view('weeks/firstweek', [
                    'proposal' => $proposal,
                    'user' => $user,
                ]);
                break;

            case 2:
                $mode = $request->session()->get('mode', 'random');
                switch($mode){
                    case 'random':
                        $proposals=Proposal::where('active', '1')->inRandomOrder()->get();
                        break;
                    
                    case 'likes':
                        $proposals=Proposal::where('active', '1')->inRandomOrder()->get()->sortByDesc('proposal_likes');
                        break;
        
                }
                $user = Auth::user();
                return view('weeks/secondweek', [
                    'proposals' => collect($proposals),
                    'user' => $user,
                ]);
                break;

            case 3:
                $user = Auth::user();
                $proposal = false;
                $comments = 0;
                if($user->activeProposal()->exists()){
                    $proposal = $user->activeProposal()->get();
                    $proposal = $proposal[0];
                    $comments = $proposal->comments()->whereNull('rel_comment_id')->get();
                }
                return view('weeks/thirdweek', [
                    'proposal' => $proposal,
                    'comments' => $comments,
                    'user' => $user,
                ]);
                break;
            case 4:
                $proposals=Proposal::all()->where('active', '1');
                $user = Auth::user();
                return view('weeks/fourthweek', [
                    'proposals' => $proposals,
                    'user' => $user,
                ]);
                break;
            case 5:
                $proposals=Proposal::all()->where('active', '1');
                return view('weeks/fifthweek', [
                    'proposals' => $proposals,
                ]);
                break;
        }
    }

    //Admin Page
    public function admin(){
        $proposals = Proposal::all()->where('active', '1');
        $user = Auth::user();
        $data = 
            [
                'proposals' => $proposals,
                'user' => $user,
            ];
        if($user['student_level'] == 5){
            $students = User::all()->sortByDesc('student_level');
            $data['students'] = $students;
        }
        return view('admin', $data);
    }

    //Profile Page
    public function profile($id){
        $data = [];
        $userAccessing = Auth::user();
        if($id == $userAccessing['id']){
            $user = $userAccessing;
            
            $data['numberLikeNots'] = $user->notifications()->where('type', 'like')->count();
            $data['commentNots'] = $user->notifications()->where('type', 'comment')->get();
            $data['reportNots'] = $user->notifications()->where('type', 'report')->get();
            
            //cancelling notifications
                $likes = Notification::where('type', 'like')->where('user_id', $user['id'])->select('id')->get();
                Notification::destroy($likes);

                NotificationsController::seen();
        }else{
            $user = User::find($id);
        }
        $data['user'] = $user;

        return view('profile', $data);
    }

    //News Page
    public function news(){
        $news = News::with('newsImages')->get()->sortByDesc('created_at');
        $user = Auth::user();
        return view('news', [
            'news' => $news,
            'user' => $user,
        ]);
    }

    //Documentation
    public function documentation(){
        return view('documentation');
    }

    //Change Week
    public function changeWeek($week){
        switch ($week) {
            case 1:
                // Resetting all every needed table

                // Notification::truncate();
                // Like::truncate();
                // Report::truncate();
                // Comment::truncate();
                // Proposal::truncate();

                break;
            case 2:
                break;
            case 3:
                $proposals = Proposal::all()->sortByDesc('proposal_likes');
                for($i = 0; $i<5; $i++){
                    $proposals->shift();
                }
                foreach($proposals as $proposal){
                    $proposal->update(['active' => 0]); 
                }
                break;
            case 4: 
                Like::truncate();
            case 5:
                $proposals = Proposal::all()->sortByDesc('proposal_likes');
                for($i = 0; $i<3; $i++){
                    $proposals->shift();
                }
                foreach($proposals as $proposal){
                    $proposal->update(['active' => 0]); 
                }
                break;
        }
        $config = Config::first();
        $config->update(['week' => $week]);
    }
    
    public function testcron(){
        $config = Config::find(1);
        $config->update(['week' => 2]);
        
    }
    //ERROR PAGE
    public function errorPage($error){
        return view('errorPage', ['error' => $error]);
    }

    //Test Page
    public function provaPage(){
        $proposal = Auth::user()->activeProposal();
        return view('provaPage', [
            'proposal' => $proposal,
        ]);
    }

    public function back(){
        return back();
    }
}

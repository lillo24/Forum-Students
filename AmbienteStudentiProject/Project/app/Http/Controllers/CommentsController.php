<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Comment;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showComments($id)
    {
        $whichWeek = Config::first()['week'];
        if($whichWeek == 2){
            $comments = Comment::where('proposal_id', $id)->whereNull('rel_comment_id')->get()->sortByDesc('comment_likes');
            $myComments = [];
            foreach($comments as $comment){
                if($comment['user_id'] == Auth::id()){
                    array_unshift($myComments, $comment);
                    $comments = $comments->reject(function ($comment) {
                        return $comment->user_id == Auth::id();
                    });
                }
            }
            foreach($myComments as $myComment){
                $comments->prepend($myComment);
            }
            return view('comments', [
                'comments' => $comments,
                'proposal' => Proposal::find($id),
                'isProposal' => true,
            ]);
        }else{
            return redirect()->route('errorPage' , 'wrongRoute');
        }
    }

    public function showOneComment($comment_id)
    {
        $whichWeek = Config::first()['week'];
        if($whichWeek == 2){
            $relComment = Comment::find($comment_id);
            $commentAsProposal = new Comment;
            $commentAsProposal['id'] = $relComment['id'];
            $commentAsProposal['proposal_title'] = 'Uno studente';
            $commentAsProposal['proposal_text'] = $relComment['comment_text'];
            $commentAsProposal['proposal_id'] = $relComment['proposal_id'];
            $commentAsProposal['proposal_likes'] = $relComment['comment_likes'];
            return view('comments', [
                'comments' => $relComment->relatedComments()->get(),
                'proposal' => $commentAsProposal,
                'isProposal' => false,
            ]);
        }else{
            return redirect()->route('errorPage' , 'wrongRoute');
        }
    }

    public function relComments($comment_id)
    {
        $whichWeek = Config::first()['week'];
        if($whichWeek == 2){
            $relComment = Comment::find($comment_id);
            if($relComment->commentLevel() == 3 Or $relComment->commentLevel() == 7){
                return route('showOneComment', $comment_id);
            }
            $relComments = $relComment->relatedComments()->get();
            $htmlRelComments = [];
            foreach($relComments as $relComment){
                $myOwnComment = "";
                $hasAnswers = "";
                $comment_id = $relComment['id'];
                $comment_text = $relComment['comment_text'];
                $deletedComment = ($relComment['comment_text'] == 'Commento cancellato') ? true : false;
                $nLikes = $relComment['comment_likes'];
                if($relComment->relatedComments()->exists()){
                    $nRelComments = $relComment->relatedComments()->count();
                    $hasAnswers = "<div class='w-100 position-absolute d-flex justify-content-center' style='color: rgb(142,142,142);bottom:-11px;font-size: 14px;'><div id='showAnswers$comment_id' class='pe-2 ps-2 show-answers-button user-select-none' style='background-color:white;width:fit-content;cursor:pointer'>Vedi risposte ($nRelComments)</div></div>";
                }
                if(!$deletedComment){
                    if($relComment['user_id'] == Auth::id()){
                        $myOwnComment = "<div id='deleteButton$comment_id' class='delete-button material-symbols-outlined me-2 text-danger user-select-none' style='font-size: clamp(15px,3vw,17px);cursor:pointer;flex: 0 1 auto;'>delete</div>";
                    }
                }
                $commentPattern = "<div class='comment-container d-flex flex-column ms-2 me-2'><div id='comment$comment_id' class='mb-3 position-relative " . ($deletedComment ? "text-muted" : "") . "'><div class='d-flex align-items-center ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(17px,2vw,20px);'>Uno studente</div></div>$myOwnComment<div  id='numberLikes$comment_id' class='me-1 text-muted' style='font-size: 13px;margin-top:-2px;'>$nLikes</div><div id='likeButton$comment_id' class='like-button material-symbols-outlined user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 border-bottom' style='font-size: clamp(15px,2vw,18px);padding-bottom:2.5rem;'><div id='textDiv$comment_id' class='ms-1 collapseLinesComment' style='white-space:pre-line; word-break:break-word;'>$comment_text</div></div><div class='w-100 position-absolute' style='bottom:0px;'>$hasAnswers<div  id='reply$comment_id' class='reply-button me-3 mb-2 d-flex align-items-center d-inline'>Rispondi</div></div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer$comment_id' class='flex-column border-end border-start' style='width:95%;'></div></div></div>";
                array_push($htmlRelComments, $commentPattern);
            }
            return $htmlRelComments;
        }elseif($whichWeek == 3){
            $relComment = Comment::find($comment_id);
            if($relComment->commentLevel() == 3 Or $relComment->commentLevel() == 7){
                return route('showOneComment', $comment_id);
            }
            $relComments = $relComment->relatedComments()->get();
            $htmlRelComments = [];
            foreach($relComments as $relComment){
                $hasAnswers = "";
                $comment_id = $relComment['id'];
                $comment_text = $relComment['comment_text'];
                if($relComment->relatedComments()->exists()){
                    $nRelComments = $relComment->relatedComments()->count();
                    $hasAnswers = "<div class='w-100 position-absolute d-flex justify-content-center' style='color: rgb(142,142,142);bottom:-11px;font-size: 14px;'><div id='showAnswers$comment_id' class='pe-2 ps-2 show-answers-button' style='background-color:white;width:fit-content;cursor:pointer'>Vedi risposte ($nRelComments)</div></div>";
                }
                $commentPattern = "<div class='comment-container d-flex flex-column ms-2 me-2'><div id='comment$comment_id' class='mb-3 position-relative'><div class='d-flex align-items-center ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(17px,2vw,20px);'>Uno studente</div></div><div id='likeButton$comment_id' class='like-button material-symbols-outlined ms-2 user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 border-bottom' style='font-size: clamp(15px,2vw,18px);padding-bottom:2.5rem;'><div id='textDiv$comment_id' class='ms-1 collapseLinesComment' style='white-space:pre-line; word-break:break-word;'>$comment_text</div></div><div class='w-100 position-absolute' style='bottom:0px;'>$hasAnswers</div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer$comment_id' class='flex-column border-end border-start' style='width:95%;'></div></div></div>";
                array_push($htmlRelComments, $commentPattern);
            }
            return $htmlRelComments;
        }else{
            return redirect()->route('errorPage' , 'wrongRoute');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieveAllComments($proposal_id){
        $isPrincipal = (Auth::user()['student_level'] == 5) ? true : false;
        $comments = Comment::where('proposal_id', $proposal_id)->whereNull('rel_comment_id')->get()->sortByDesc('comment_likes');
        $htmlComments = [];
        $deleteButton = "";
        $email = "";
        foreach($comments as $comment){
            $relatedComments = "";
            if($comment->relatedComments()->exists()){
                $relatedComments = $this->foreachComments($comment, $isPrincipal);
            }
            $comment_id = $comment['id'];
            $comment_text = $comment['comment_text'];
            $deletedComment = ($comment['comment_text'] == 'Commento cancellato') ? true : false;
            $nLikes = $comment['comment_likes'];
            if($isPrincipal){
                $deleteButton = "<div id='deleteButton$comment_id' class='delete-comment material-symbols-outlined me-2 user-select-none text-danger' style='font-size: 20px;cursor:pointer;flex: 0 1 auto;'>delete</div>";
                $email = "<div class='d-inline p-1' style='border:1px black solid;width:150px;overflow:hidden;text-overflow:ellipsis;'>{$comment->user()->first()['email']}</div>";
            }
            $commentPattern = "<div class='comment-container flex-column ms-2 me-2' style='display:flex'><div id='comment$comment_id' class='mb-3 position-relative " . ($deletedComment ? "text-muted" : "") . "'><div class='d-flex align-items-center ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(17px,2vw,20px);'>Uno studente</div></div>$email $deleteButton<div id='reportButton$comment_id' class='report-button material-symbols-outlined me-2 user-select-none' style='font-size: 20px;cursor:pointer;flex: 0 1 auto;'>flag</div><div  id='numberLikes$comment_id' class='text-muted' style='font-size: 13px;'>$nLikes</div><div id='likeButton$comment_id' class='like-button material-symbols-outlined ms-2 user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 border-bottom' style='font-size: clamp(15px,2vw,18px);padding-bottom:2.5rem;'><div id='textDiv$comment_id' class='ms-1 collapseLinesComment text-div' style='white-space:pre-line; word-break:break-word;'>$comment_text</div></div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer$comment_id' class='flex-column border-end border-start' style='width:95%;'>$relatedComments</div></div></div>";
            array_push($htmlComments, $commentPattern);
        }
        return $htmlComments;
    }

    public function foreachComments (Comment $relComment, $isPrincipal){
        $deleteButton = "";
        $email = "";
        $comments = $relComment->relatedComments()->get();
        $relatedComments = "";
        foreach($comments as $comment){
            if($comment->relatedComments()->exists()){
                $relatedLvlLessComments = $this-> foreachComments ($comment, $isPrincipal);
                $comment_id = $comment['id'];
                $comment_text = $comment['comment_text'];
                $deletedComment = ($comment['comment_text'] == 'Commento cancellato') ? true : false;
                $nLikes = $comment['comment_likes'];
                if($isPrincipal){
                    $deleteButton = "<div id='deleteButton$comment_id' class='delete-comment material-symbols-outlined me-2 user-select-none text-danger' style='font-size: 20px;cursor:pointer;flex: 0 1 auto;'>delete</div>";
                    $email = "<div class='d-inline p-1' style='border:1px black solid;width:150px;overflow:hidden;text-overflow:ellipsis;'>{$comment->user()->first()['email']}</div>";
                }
                $relatedComment = "<div class='comment-container flex-column ms-2 me-2' style='display:flex'><div id='comment$comment_id' class='mb-3 position-relative " . ($deletedComment ? "text-muted" : "") . "'><div class='d-flex align-items-center ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(17px,2vw,20px);'>Uno studente</div></div>$email $deleteButton<div id='reportButton$comment_id' class='report-button material-symbols-outlined me-2 user-select-none' style='font-size: 20px;cursor:pointer;flex: 0 1 auto;'>flag</div><div id='numberLikes$comment_id' class='text-muted' style='font-size: 13px;'>$nLikes</div><div id='likeButton$comment_id' class='like-button material-symbols-outlined ms-2 user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 border-bottom' style='font-size: clamp(15px,2vw,18px);padding-bottom:2.5rem;'><div id='textDiv$comment_id' class='ms-1 collapseLinesComment text-div' style='white-space:pre-line; word-break:break-word;'>$comment_text</div></div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer$comment_id' class='flex-column border-end border-start' style='width:95%;'>$relatedLvlLessComments</div></div></div>";
            }else{
                $comment_id = $comment['id'];
                $comment_text = $comment['comment_text'];
                $deletedComment = ($comment['comment_text'] == 'Commento cancellato') ? true : false;
                $nLikes = $comment['comment_likes'];
                if($isPrincipal){
                    $deleteButton = "<div id='deleteButton$comment_id' class='delete-comment material-symbols-outlined me-2 user-select-none text-danger' style='font-size: 20px;cursor:pointer;flex: 0 1 auto;'>delete</div>";
                    $email = "<div class='d-inline p-1' style='border:1px black solid;width:150px;overflow:hidden;text-overflow:ellipsis;'>{$comment->user()->first()['email']}</div>";
                }
                $relatedComment = "<div class='comment-container  flex-column ms-2 me-2' style='display:flex'><div id='comment$comment_id' class='mb-3 position-relative " . ($deletedComment ? "text-muted" : "") . "'><div class='d-flex align-items-center ps-3 pe-3 pt-3 pb-1'><div style='flex: 1 1 auto;'><div style='font-size: clamp(17px,2vw,20px);'>Uno studente</div></div>$email $deleteButton<div id='reportButton$comment_id' class='report-button material-symbols-outlined me-2 user-select-none' style='font-size: 20px;cursor:pointer;flex: 0 1 auto;'>flag</div><div id='numberLikes$comment_id' class='text-muted' style='font-size: 13px;'>$nLikes</div><div id='likeButton$comment_id' class='like-button material-symbols-outlined ms-2 user-select-none' style='font-size: clamp(15px,2vw,17px);cursor:pointer;flex: 0 1 auto;'>favorite</div></div><div class='ps-4 pe-2 border-bottom' style='font-size: clamp(15px,2vw,18px);padding-bottom:2.5rem;'><div id='textDiv$comment_id' class='ms-1 collapseLinesComment text-div' style='white-space:pre-line; word-break:break-word;'>$comment_text</div></div></div><div class='d-flex w-100 justify-content-center'><div id ='relCommentsContainer$comment_id' class='flex-column border-end border-start' style='width:95%;'></div></div></div>";
            }
            $relatedComments .= $relatedComment;
        }
        return $relatedComments;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $comment = new Comment();

        $isRelated = ($request['rel_comment_id'] != 'null');

        $comment->comment_text = $request['comment_text'];
        $comment->proposal_id = $request['proposal_id'];
        $comment->user_id = $user['id'];
        if($isRelated){$comment->rel_comment_id = $request['rel_comment_id'];}

        $comment->save();

        $userIdOfProposal = Proposal::find($request['proposal_id'])['user_id'];
        if($userIdOfProposal != $user['id']){
            $data = [];
            $data['comment_id'] = $comment['id'];

            if($isRelated){
                $data['comment_referred_id'] = $request['rel_comment_id'];
            }

            NotificationsController::store('comment', $userIdOfProposal, $data);
            
        }
        
        return response()->json([$comment]);
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
     * Deleted for the users but not from the storage
     */

    public function cancel($id)
    {
        $comment = Comment::find($id);

        $comment->update(['comment_text' => 'Commento cancellato']);
        return response()->json([true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        Comment::destroy($id);
        return response()->json([true]);
    }
}

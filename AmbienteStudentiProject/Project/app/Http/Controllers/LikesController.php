<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Comment;
use App\Models\Proposal;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikesController extends Controller
{
    public function like($parent_id, $type)
    {
        $user_id = Auth::id();
        if($type == 'proposal'){
            if (Like::where('parent_id', $parent_id)->where('user_id', $user_id)->exists()) {

                //Destroy Like
                $like = Like::where('parent_id', $parent_id)->where('user_id', $user_id)->select('id')->get();
                Like::destroy($like);
    
                //Increment proposal like (Convention)
                $proposal = Proposal::find($parent_id);
                $proposal->decrement('proposal_likes');
    
                //Destroy notification
                Notification::destroy(Notification::where('type', 'like')->where('user_id' , $proposal->user()->get()[0]['id'])->select('id')->get());
    
                return "destroyed";
            }else{
                $like = new Like;
                
                $like->user_id = $user_id;
                $like->type = $type;
                $like->parent_id = $parent_id;

                $like->save();
    
                $proposal = Proposal::find($parent_id);
                $proposal->increment('proposal_likes');
        
                $data = [];
                NotificationsController::store('like', $proposal->user()->get()[0]['id'], $data);

                return "saved";
            }
        }else{
            if (Like::where('parent_id', $parent_id)->where('user_id', $user_id)->exists()) {

                //Destroy Like
                $like = Like::where('parent_id', $parent_id)->where('user_id', $user_id)->select('id')->get();
                Like::destroy($like);
    
                //Increment comment like (Convention)
                $comment = Comment::find($parent_id);
                $comment->decrement('comment_likes');
    
                return "destroyed";
            }else{
                $like = new Like;
                
                $like->user_id = $user_id;
                $like->type = $type;
                $like->parent_id = $parent_id;
        
                $like->save();

                $comment = Comment::find($parent_id);
                $comment->increment('comment_likes');

                return "saved";
            }
        }
    }
}

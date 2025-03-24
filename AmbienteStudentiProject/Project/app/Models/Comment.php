<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $table = "COMMENTSTABLE";
    protected $fillable = [
        'comment_text',
        'comment_likes',
        'proposal_id',
        'user_id',
        'rel_comment_id',
    ];
    public function proposal(){
        return $this->belongsTo(Proposal::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function relatedComments(){
        return $this->hasMany(Comment::class, 'rel_comment_id', 'id');
    }
    public function parentComment(){
        return $this->hasOne(Comment::class, 'id', 'rel_comment_id');
    }
    public function commentLevel(){
        $while = true;
        $level = 0;
        $comment = $this;
        while($while){
            if($comment->parentComment()->exists()){
                $level = $level + 1;
                $comment = $comment->parentComment()->get()[0];
            }else{
                $while = false;
            }
        }
        return $level;
    }
    public function userLiked()
    {
        if(Like::where('user_id', Auth::id())->where('parent_id', $this['id'])->exists()){
            return true;
        }else{return false;}
    }
}

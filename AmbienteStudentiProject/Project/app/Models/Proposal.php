<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proposal extends Model
{
    use HasFactory;
    protected $table = "PROPOSALSTABLE";
    protected $fillable = [
        'proposal_title',
        'proposal_text',
        'proposal_likes',
        'user_id',
        'active',
    ];

    //Relations 
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //Who liked
    public function userLiked()
    {
        if(Like::where('user_id', Auth::id())->where('parent_id', $this['id'])->exists()){
            return true;
        }else{return false;}
    }
}

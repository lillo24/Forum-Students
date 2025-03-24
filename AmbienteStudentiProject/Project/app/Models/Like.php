<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;
    protected $table = "LIKESTABLE";
    protected $fillable = [
        'parent_id',
        'user_id',
    ];

    public $timestamps = false;

    public function parent(){
        if($this['type'] == 'proposal'){
            return $this->belongsTo(Proposal::class, 'id', 'proposal_id');
        }else{
            return $this->belongsTo(Comment::class, 'id', 'comment_id');
        }
        
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

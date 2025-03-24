<?php

namespace App\Models;

use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $table = "NOTIFICATIONSTABLE";
    protected $fillable = [
        'type',
        'user_id',
        'report_id',
        'comment_id',
        'comment_referred_id',
        'seen'
    ];
    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function report(){
        return $this->belongsTo(Report::class);
    }
    public function comment(){
        return $this->belongsTo(Comment::class);
    }
    public function commentReferred(){
        return $this->belongsTo(Comment::class, 'comment_referred_id');
    }
}

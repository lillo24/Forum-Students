<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Proposal;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "USERSTABLE";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_level',
        'name',
        'email',
        'google_id',
        'remember_token',
        'logged_before',
    ];

    //RelationsShips
    public function activeProposal()
    {
        return $this->hasOne(Proposal::class)->where('active', 1);
    }
    public function inactiveProposal()
    {
        return $this->hasMany(Proposal::class)->where('active', 0);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    //Student Level
    public function levelName()
    {
        switch($this['student_level']){
            case 0:
                return ['name' => 'Uno studente', 'image' => 'sentiment_neutral'];

            case 1: 
                return ['name' => 'Uno studente interessato', 'image' => 'mood'];

            case 2: 
                return ['name' => 'Uno studente veterano', 'image' => 'sentiment_very_satisfied'];

            case 3: 
                return ['name' => 'Un moderatore', 'image' => 'support_agent'];

            case 4: 
                return ['name' => 'Un rappresentante', 'image' => 'emoji_people'];

            case 5:
                return ['name' => 'Preside/Vice preside', 'image' => 'psychology'];
        }
    }

}
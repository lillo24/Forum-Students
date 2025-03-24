<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = "REPORTSTABLE";
    protected $fillable = [
        'report_text',
        'user_id',
        'user_reported_id',
    ];

    //Relations 

}

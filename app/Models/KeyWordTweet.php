<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyWordTweet extends Model
{
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tweet(){
        return $this->belongsTo(Tweet::class);
    }

    public function keyword(){
        return $this->belongsTo(KeyWord::class);
    }

}

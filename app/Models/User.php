<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    protected $guarded = [];
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */


    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'consumerKey',
        'consumerSecret',
        'accessToken',
        'accessTokenSecret',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function keywords()
    {
        return $this->hasMany(KeyWord::class);
    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    public function removeKeyword($id)
    {
        return $this->tweets().$this->removeKeyword($id);
    }

    public function keyWordTweet()
    {
        return $this->hasMany(KeyWordTweet::class);
    }


}

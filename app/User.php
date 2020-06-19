<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function answers(){
        return $this->hasMany('App\CommentAnswer');
    }

    public function commentsLike(){
        return $this->hasMany('App\CommentsLike');
    }

    public function commentsDislike(){
        return $this->hasMany('App\CommentsDislike');
    }

    public function answersLike(){
        return $this->hasMany('App\AnswerLikes');
    }

    public function answersDislike(){
        return $this->hasMany('App\AnswerDislikes');
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }
    public function getJWTCustomClaims(){
        return [];
    }

    public function setPasswordAttribute($value){
        return $this->attributes['password'] = bcrypt($value);
    }
}

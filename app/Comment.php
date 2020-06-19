<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id','user_name','book_id','contenu'];
    public function book(){
        return $this->belongsTo('App\Book');
    }
    public function answers(){
        return $this->hasMany('App\CommentAnswer');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likedBy(){
        return $this->hasMany('App\CommentsLike');
    }

    public function dislikedBy(){
        return $this->hasMany('App\CommentsDislike');
    }
}

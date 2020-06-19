<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentAnswer extends Model
{
    protected $fillable = ['user_id','user_name','contenu','comment_id'];
    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function dislikedBy(){
        return $this->hasMany('App\AnswerDislikes','answer_id');
    }

    public function likedBy(){
        return $this->hasMany('App\Answerlikes','answer_id');
    }
}

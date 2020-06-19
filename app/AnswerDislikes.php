<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerDislikes extends Model
{
    
    protected $fillable = ['user_id','answer_id'];
    public function user(){
        return $this->belongsTo('App\user');
    }
    public function answer(){
        return $this->belongsTo('App\CommentAnswer');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{  

    protected $fillable = ['titre','auteur','image','description'];
    public $timestamps = false;

    public function comments(){
        return $this->hasMany('App\Comment');
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /*return parent::toArray($request);*/
        return [
          'id'=>$this->id,
          'titre'=>$this->titre,
          'auteur'=>$this->auteur,
          'image'=>$this->image,
          'description'=>$this->description,
          'comments' =>$this->allAboutComments($this->comments)
        ];

    }

    public function allAboutComments($comments){
          $allAboutComments = [];
          foreach($comments as $comment){
                $comment->liked_By = $comment->likedBy;
                $comment->disliked_By = $comment->dislikedBy;
                $comment->answers= $comment->answers;
                foreach ($comment->answers as $answer){
                    $answer->liked_By = $answer->likedBy;
                    $answer->dislike_By  = $answer->dislikedBy;
                } 
          }
        return $comments;
    }
}

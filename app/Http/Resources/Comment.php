<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' =>$this->id,
          'user_id'=>$this->user_id,
          'user_name'=>$this->user_name,
          'book_id'=>$this->book_id,
          'contenu'=>$this->contenu,
          'created_at'=>$this->created_at,
          'liked_by'=>$this->likedBy,
          'disliked_by'=>$this->dislikedBy,
          'answers'=>$this->allAboutAnswers($this->answers)

        ];
    }

    public function allAboutAnswers($answers){
        if (empty($answer) || !isset($answer)) return [];
        foreach($answers as $answer){
            $answer->liked_by = $answer->likedBy;
            $answer->disliked_by = $answer->dislikedBy;
        }
    }

}

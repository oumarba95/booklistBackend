<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Answer extends JsonResource
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
           'id'=>$this->id,
           'user_id'=>$this->user_id,
           'user_name'=>$this->user_name,
           'comment_id'=>$this->comment_id,
           'contenu' =>$this->contenu,
           'created_at'=>$this->created_at,
           'liked_by'=>$this->likedBy,
           'disliked_by'=>$this->dislikedBy
        ];
    }
}

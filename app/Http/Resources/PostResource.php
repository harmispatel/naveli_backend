<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         $file_extension = $this->file_type;
        if($file_extension == "link"){
            $post = $this->posts;
        }elseif($file_extension == "image"){
            $post = asset('/public/images/uploads/newsPosts/'.$this->posts);
        }else{
            $post = null;
        }

        return [
            'id' => $this->id,
            'parent_title' => isset($this->parent_title) ? strval($this->parent_title)  : null,
            'description' => isset($this->description) ? $this->description  : null,
            'posts' => isset($this->posts) ? $post : null,
            'file_type' => isset($this->file_type) ? $this->file_type  : null,
        ];
    }
}

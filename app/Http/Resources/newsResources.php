<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class newsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['id']  = (isset($this->id)) ? $this->id : "";
        $data['title']  = (isset($this->title)) ? $this->title : "";
        $data['description']  = (isset($this->description)) ? $this->description : "";
        $data['file_type']  = (isset($this->file_type)) ? $this->file_type : "";

        if(isset($this->file_type) && $this->file_type == 'image'){
            $data['posts'] = (isset($this->posts) && !empty($this->posts) && file_exists('public/images/uploads/newsPosts/'.$this->posts)) ? asset('/public/images/uploads/newsPosts/'.$this->posts) : '';
        }else{
            $data['posts'] = (isset($this->posts)) ? $this->posts : "";
        }
        return $data;
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AskYourQuestionResource extends JsonResource
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
        $image = '';

        if($file_extension == 'image'){
            $image = asset('public/images/uploads/askQuestion/'. $this->image);
        }elseif($file_extension == 'link'){
            $image = $this->image;
        }else{
            $image = NULL;
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'user_question' => $this->user_question,
            'image' => $image,
            'file_type' => $this->file_type,
            'question_answer' => $this->question_answer,
        ];
    }
}

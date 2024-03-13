<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAnswersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $answers = isset($this->resource) ? $this->resource : [];
        $data = [];

        if(count($answers) > 0){
            $item = [];
            foreach($answers as $answer){
                $item['question_id'] = (isset($answer->question_id)) ? $answer->question_id : '';
                $item['option_id'] = (isset($answer->question_option_id)) ? $answer->question_option_id : '';
            }
            $data[] = $item;
        }

        return $data;
    }
}

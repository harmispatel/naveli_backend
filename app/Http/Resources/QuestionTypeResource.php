<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
               'id' => $this->id,
               'name' => $this->name,
               'icon' => isset($this->icon) ? asset('/public/images/uploads/QuestionType/'. $this->icon) : null,
        ];
    }
}

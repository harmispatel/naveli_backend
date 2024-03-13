<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class HealthMixResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $file_extension = $this->media_type;
        $post = '';

        if ($file_extension == "link") {
            $post = $this->media;
        } elseif ($file_extension == "image" || $file_extension == "video") {
            $post = asset('/public/images/uploads/healthmix/' . $this->media);
        } else {
            $post = "no extension";
        }

        $diff = $this->created_at->diffForHumans();

        if (strpos($diff, 'second') !== false) {
            $diffInHumanReadable = str_replace('seconds', 'sec.', $diff);
        } elseif (strpos($diff, 'minute') !== false) {
            $diffInHumanReadable = str_replace('minutes', 'min.', $diff);
        } elseif (strpos($diff, 'hour') !== false) {
            $diffInHumanReadable = str_replace('hours', 'hr.', $diff);
        } elseif (strpos($diff, 'day') !== false) {
            $diffInHumanReadable = str_replace('days', 'day', $diff);
        } elseif (strpos($diff, 'month') !== false) {
            $diffInHumanReadable = str_replace('months', 'mon.', $diff);
        } elseif (strpos($diff, 'year') !== false) {
            $diffInHumanReadable = str_replace('years', 'year', $diff);
        } else {
            $diffInHumanReadable = "";
        }

        return [
            'id' => $this->id,
            'health_type' => $this->health_type,
            'media' => isset($this->media) ? $post : null,
            'media_type' => $this->media_type,
            'hashtags' => $this->hashtags,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'diffrence_time' => $diffInHumanReadable,

        ];
    }
}

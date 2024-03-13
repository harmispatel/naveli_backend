<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /*
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
            'email' => $this->email,
            'role_id' => $this->role_id,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'random_code' => $this->random_code,
            'mobile' => $this->mobile,
            'device_token' => $this->device_token,
            'image' => isset($this->image) ? asset('/public/images/uploads/user_images/' . $this->image) : '', // Append public path for the image
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'status' => $this->status,
            'remember_token' => $this->remember_token,
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\HealthMixResource;
use App\Models\HealthMix;
use App\Models\HealthMixLike;
use Illuminate\Http\Request;

class HealthMixController extends BaseController
{
    public function index(Request $request)
    {
        try {
            $title_id = $request->title_id;
            if ($title_id == 7) {
                $getHealthMixesList = HealthMix::latest()->get();
            } else {
                $getHealthMixesList = HealthMix::where('health_type', $title_id)->get();
            }
            $data = ['HealthMixPosts' => HealthMixResource::collection($getHealthMixesList)];
            return $this->sendResponse($data, 'Health Mix Posts Received Successfully.', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function likeDislike(Request $request)
    {
        try {
            $login_user_id = auth()->user()->id;
            $check_User_likes = HealthMixLike::where('health_mix_id', $request->health_mix_id)->where('user_id', $login_user_id)->first();

            if (isset($check_User_likes)) {
                $update = $check_User_likes->update([
                    'is_like' => $request->is_like,
                ]);

                return $this->sendResponse(null, 'Data Updated Successfully', true);
            }
            $store_user_likes = HealthMixLike::create([
                'user_id' => auth()->user()->id,
                'health_mix_id' => $request->health_mix_id,
                'is_like' => $request->is_like,
            ]);

            return $this->sendResponse(null, 'Data Saved Successfully', true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function getUserLikesOrDislikes(Request $request){

        try {
            $authUser = auth()->user();
            if($authUser){
                $getUserLikesOrDislikes = HealthMixLike::select('user_id', 'health_mix_id', 'is_like')
                ->where('user_id', $authUser->id)
                ->get();
               return $this->sendResponse($getUserLikesOrDislikes, 'User Likes Or Dislikes Received Successfully', true);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

}

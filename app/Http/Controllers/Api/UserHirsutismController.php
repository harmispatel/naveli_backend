<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\UserHirsutism;

class UserHirsutismController extends BaseController
{
    public function storeUserHirsutism(Request $request)
    {
        try {
            $input = $request->except('user_id','date');
            $input['user_id'] = (auth()->user()) ? auth()->user()->id : '';

            if($input['user_id']){
                $created_at = isset($request->date) ? $request->date : now()->toDateString();
                $user_hirsutism = UserHirsutism::whereDate('created_at',$created_at)->where('user_id', $input['user_id'])->first();

                if(isset($user_hirsutism->id)){
                    UserHirsutism::find($user_hirsutism->id)->update($input);
                    return $this->sendResponse(null,'Data Updated SuccessFully',true);
                }else{
                    UserHirsutism::create($input);
                    return $this->sendResponse(null,'Data Saved SuccessFully',true);
                }
            }else{
                return $this->sendResponse(null, 'User Not Found!',false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'something went wrong',false);
        }
    }

    public function getUserHirsutism()
    {
        try {
            $user_hirsutism = UserHirsutism::where('user_id', auth()->user()->id)->whereDate('created_at', date('Y-m-d'))->first();

            if(isset($user_hirsutism->id)){
                return $this->sendResponse($user_hirsutism, "Data has been Retrived.", true);
            }else{
                return $this->sendResponse(null, "Data Not Found!", false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, "Something went wrong!", false);
        }
    }
}

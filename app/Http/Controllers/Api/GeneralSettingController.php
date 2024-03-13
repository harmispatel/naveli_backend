<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralSettingController extends BaseController
{
   public function getGeneralSetting(Request $request){
     try{

        $generalSetting = GeneralSetting::first();
        $data['flash_screen'] = isset($generalSetting->flash_screen) ? asset('/public/images/uploads/general_image/'. $generalSetting->flash_screen) : '';

        return $this->sendResponse($data,'General setting list retrieved successfully.',true);
       
     }catch(\Throwable $th){
        return $this->sendResponse($data,'Something Went Wrong!',false);
     }

   }
}

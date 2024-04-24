<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralSettingController extends BaseController
{
   public function getGeneralSettingFlashScreen(Request $request){
     try{

        $generalSetting = GeneralSetting::first();
        $data['flash_screen'] = isset($generalSetting->flash_screen) ? asset('/public/images/uploads/general_image/'. $generalSetting->flash_screen) : '';

        return $this->sendResponse($data,'FlashScreen retrieved successfully.',true);
       
     }catch(\Throwable $th){
        return $this->sendResponse($data,'Something Went Wrong!',false);
     }
   }

   public function getAboutAndDescription(){
      try {
         $generalData = GeneralSetting::first();
         $data['term_and_condition'] = $generalData->term_and_condition;
         $data['description'] = $generalData->description;
         $data['about_us'] = $generalData->about_us;

         return $this->sendResponse($data,'Generaldata retrieved successfully.',true);
      } catch (\Throwable $th) {
         return $this->sendResponse(null,'Internal server error',false);
      }
   }

}

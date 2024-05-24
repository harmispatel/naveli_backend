<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\AllAboutPeriodPost;
use App\Models\AllAboutPeriodPostMedia;
use Illuminate\Http\Request;

class AllAboutPeriodController extends BaseController
{
    public function getAllAboutPeriodsList(Request $request){

        try {
            if(isset($request->language_code) && !empty($request->language_code)){

                $getAllAboutPeriodsList = AllAboutPeriodPost::all();
                $getAllAboutPeriodsList = $getAllAboutPeriodsList->map(function ($allAboutPeriodPost) use ($request){
                    return [
                        'id' => $allAboutPeriodPost->id,
                        'category_name' => $allAboutPeriodPost['category_name_' . $request->language_code] ?? '',
                        'category_icon' => isset($allAboutPeriodPost->category_icon) ? asset('public/images/uploads/all_about_periods/category_icons/'.$allAboutPeriodPost->category_icon) : null,
                    ];
                });
                return $this->sendResponse($getAllAboutPeriodsList,'All About Periods Category retrived SuccessFully',true);
               

            }else{
                return $this->sendResponse(null, 'Language Code not Found!', false);
            }
            
        } catch (\Throwable $th) {
           return $this->sendResponse(null, 'Something Went Wrong!', false);
        }
    }

    public function getDetailOfAllAboutPeriod(Request $request){
        try {
            if(isset($request->language_code) && !empty($request->language_code) && isset($request->category_id)){
                
                $categoryId = $request->category_id;
                $findCategory = AllAboutPeriodPost::find($categoryId);
    
                if(empty($findCategory)){
                    return $this->sendResponse(null, 'This Category Id Not Found!', false);
                }else{
                    $getDetailOfCategory = AllAboutPeriodPostMedia::where('post_id',$findCategory->id)->get();

                    $getDetailListOfCategory = $getDetailOfCategory->map(function ($allAboutPeriodPostMedia) use ($request){
                        return [
                            'media' => ($allAboutPeriodPostMedia->media_type == 'image') ? asset('public/images/uploads/all_about_periods/posts_media/'.$allAboutPeriodPostMedia->media) : $allAboutPeriodPostMedia->media,
                            'media_type' => $allAboutPeriodPostMedia->media_type,
                            'description' => $allAboutPeriodPostMedia['description_' . $request->language_code] ?? '',
                        ];
                    });
                    return $this->sendResponse($getDetailListOfCategory,'Media And Desc. Retrived SuccessFully For '. $findCategory['category_name_' .$request->language_code],true);
                }
            
            }else{
                return $this->sendResponse(null, 'Required Parameters not Found!', false);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong!', false);
        }
    }
}

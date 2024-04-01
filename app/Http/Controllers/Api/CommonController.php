<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use DB;
use Illuminate\Http\Request;

class CommonController extends BaseController
{
    public function stateList(){
    
        try {
            $stateList = DB::table('states')->select('id','name')->get();

            return $this->sendResponse($stateList,'stateList retrived SuccessFully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal Server Error!',false);
        }
    }

    public function cityList(Request $request){
        try {
               $id = $request->state_id;
               if(isset($id) && !empty($id)){
                $cityList = DB::table('cities')->where('state_id',$id)->select('id','name')->get();
               }else{
                return $this->sendResponse(null,'id is required',false);
               }
         
            return $this->sendResponse($cityList,'cityList retrived SuccessFully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal Server Error!',false);
        }
    }

    public function festivalList(){
        try {
            $festival = Festival::all();

            return $this->sendResponse($festival);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Festival;
use App\Models\Home;
use App\Models\User;
use App\Traits\ImageTrait;
use App\Models\DailyDairy;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Http\Request;

class CommonController extends BaseController
{
    use ImageTrait;

    public function storeState(Request $request){
        try {
          $state_id = $request->state_id;

          $state = DB::table('states')->where('id',$state_id)->first();

            if($state){
                    $stateName = $state->name;
            
                      $user = User::find(auth()->user()->id);
            
                      $storeState = $user->update([
                           'state' => $stateName,
                      ]);
                      
            }else{
                 return $this->sendResponse(null,'State not found',false);
            }
      
          return $this->sendResponse($storeState,'State Saved SuccsseFully',true);
        } catch (\Throwable $th) {
          
            return $this->sendResponse(null,'Internal Server Error!',false);
        }
    }

    public function stateList(){
    
        try {
            $stateList = DB::table('states')->select('id','name')->get();

            return $this->sendResponse($stateList,'stateList retrived SuccessFully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal Server Error!',false);
        }
    }
    
    public function storeCity(Request $request){
        try {
          $city_id = $request->city_id;

          $city = DB::table('cities')->where('id',$city_id)->first();

            if($city){
                    $cityName = $city->name;
            
                      $user = User::find(auth()->user()->id);
            
                      $storeState = $user->update([
                           'city' => $cityName,
                      ]);
                      
            }else{
                 return $this->sendResponse(null,'City not found',false);
            }
      
          return $this->sendResponse($storeState,'City Saved SuccsseFully',true);
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
            $currentMonth = date('m');
            $currentYear = date('Y');

        // Filter festivals for the current month
        $festivals = Festival::whereMonth('date', $currentMonth)
                             ->whereYear('date', $currentYear)
                             ->orderBy('date','ASC')
                             ->get();

            // Extract festival names
            $festivalNames = $festivals->pluck('festival_name')->toArray();

        return $this->sendResponse($festivalNames,'Festival retrived SuccessFully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal Server Error!',false);
        }
    }

    public function storeDailydairy(Request $request){
        try {
            if(isset($request->mood) && !empty($request->mood) && isset($request->music) && !empty($request->music) && isset($request->learning) && !empty($request->learning) && isset($request->cleaning) && !empty($request->cleaning) && isset($request->body_care) && !empty($request->body_care) && isset($request->gratitude) && !empty($request->gratitude) && isset($request->hang_out) && !empty($request->hang_out) && isset($request->work_out) && !empty($request->work_out) && isset($request->screen_time) && !empty($request->screen_time) && isset($request->food) && !empty($request->food) && isset($request->edit) && !empty($request->edit) && isset($request->key_activities) && !empty($request->key_activities) && isset($request->to_do_list) && !empty($request->to_do_list)){
                $dailydairys = DailyDairy::first();
                
                if($dailydairys && $dailydairys->id > 0){
                   
                    if ($request->has('mood')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->mood));
                        $file = $request->file('mood');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->mood = $image_url;
                    }
                    if ($request->has('music')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->music));
                        $file = $request->file('music');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->music = $image_url;
                    }
                    if ($request->has('learning')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->learning));
                        $file = $request->file('learning');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->learning = $image_url;
                    }
                    if ($request->has('cleaning')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->cleaning));
                        $file = $request->file('cleaning');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->cleaning = $image_url;
                    }
                    if ($request->has('body_care')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->body_care));
                        $file = $request->file('body_care');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->body_care = $image_url;
                    }
                    if ($request->has('hang_out')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->hang_out));
                        $file = $request->file('hang_out');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->hang_out = $image_url;
                    }
                    if ($request->has('work_out')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->work_out));
                        $file = $request->file('work_out');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->work_out = $image_url;
                    }
                    if ($request->has('screen_time')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->screen_time));
                        $file = $request->file('screen_time');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->screen_time = $image_url;
                    }
                    if ($request->has('food')) {
                        File::delete(public_path('/images/uploads/Daily_dairys/' . $dailydairys->food));
                        $file = $request->file('food');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $dailydairys->food = $image_url;
                    }

                    $dailydairys->gratitude = $request->gratitude;
                    $dailydairys->edit = $request->edit;
                    $dailydairys->key_activities = $request->key_activities;
                    $dailydairys->to_do_list = $request->to_do_list;
                    $dailydairys->user_id = auth()->user()->id; 
    
                    $dailydairys->save();

                    return $this->sendResponse($dailydairys,'Daily_dairy updated SuccessFully',true);
                   
                }else{
                    $input = $request->except('mood','music','learning','cleaning','body_care','hang_out','work_out','screen_time','food');
                   
                    if ($request->has('mood')) {
                        $file = $request->file('mood');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['mood'] = $image_url;
                    }
                    if ($request->has('music')) {
                        $file = $request->file('music');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['music'] = $image_url;
                    }
                    if ($request->has('learning')) {
                        $file = $request->file('learning');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['learning'] = $image_url;
                    }
                    if ($request->has('cleaning')) {
                        $file = $request->file('cleaning');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['cleaning'] = $image_url;
                    }
                    if ($request->has('body_care')) {
                        $file = $request->file('body_care');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['body_care'] = $image_url;
                    }
                    if ($request->has('hang_out')) {
                        $file = $request->file('hang_out');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['hang_out'] = $image_url;
                    }
                    if ($request->has('work_out')) {
                        $file = $request->file('work_out');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['work_out'] = $image_url;
                    }
                    if ($request->has('screen_time')) {
                        $file = $request->file('screen_time');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['screen_time'] = $image_url;
                    }
                    if ($request->has('food')) {
                        $file = $request->file('food');
                        $image_url = $this->addSingleImage('Daily_dairys', $file, $old_image = '');
                        $input['food'] = $image_url;
                    }

                    $input['user_id'] = auth()->user()->id; 
    
                    $dailydairys = DailyDairy::create($input);

                    return $this->sendResponse($dailydairys,'Daily_dairy stored SuccessFully',true);
                }
               
            }else{
                return $this->sendResponse(null,'All Field is required',false);
            }
           
        } catch (\Throwable $th) {

            return $this->sendResponse(null,'Internal Server Error!',false);
        }
    }

    public function getHomePage(){
        try {
            $getHome = Home::all();

            return $this->sendResponse($getHome,'Home page Retrived SuccessFully',true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Internal Server Error',false);
        }
    }

   
}

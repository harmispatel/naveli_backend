<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\DailyDairy;
use App\Models\Festival;
use App\Models\Home;
use App\Models\User;
use App\Traits\ImageTrait;
use DB;
use Illuminate\Http\Request;

class CommonController extends BaseController
{
    use ImageTrait;

    public function storeState(Request $request)
    {
        try {
            $state_id = $request->state_id;

            $state = DB::table('states')->where('id', $state_id)->first();

            if ($state) {
                $stateName = $state->name;

                $user = User::find(auth()->user()->id);

                $storeState = $user->update([
                    'state' => $stateName,
                ]);

            } else {
                return $this->sendResponse(null, 'State not found', false);
            }

            return $this->sendResponse($storeState, 'State Saved SuccsseFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function stateList()
    {

        try {
            $stateList = DB::table('states')->select('id', 'name')->get();

            return $this->sendResponse($stateList, 'stateList retrived SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeCity(Request $request)
    {
        try {
            $city_id = $request->city_id;

            $city = DB::table('cities')->where('id', $city_id)->first();

            if ($city) {
                $cityName = $city->name;

                $user = User::find(auth()->user()->id);

                $storeState = $user->update([
                    'city' => $cityName,
                ]);

            } else {
                return $this->sendResponse(null, 'City not found', false);
            }

            return $this->sendResponse($storeState, 'City Saved SuccsseFully', true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function cityList(Request $request)
    {
        try {
            $id = $request->state_id;
            if (isset($id) && !empty($id)) {
                $cityList = DB::table('cities')->where('state_id', $id)->select('id', 'name')->get();
            } else {
                return $this->sendResponse(null, 'id is required', false);
            }

            return $this->sendResponse($cityList, 'cityList retrived SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function festivalList()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Filter festivals for the current month
            $festivals = Festival::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->orderBy('date', 'ASC')
                ->get();

            // Extract festival names
            $festivalNames = $festivals->pluck('festival_name')->toArray();

            return $this->sendResponse($festivalNames, 'Festival retrived SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeDailydairy(Request $request)
    {
        try {
            $date = isset($request->date) ? $request->date : now()->toDateString();
            $dailydairys = DailyDairy::where('user_id',auth()->user()->id)->whereDate('created_at',$date)->get();

            if ($dailydairys) {

                $dailyDairy->update([
                   'mood' => $request->mood,
                   'music' => $request->music,
                   'learning' => $request->learning,
                   'cleaning' => $request->cleaning,
                   'body_care' => $request->body_care,
                   'gratitude' => $request->gratitude,
                   'hang_out' => $request->hang_out,
                   'work_out' => $request->work_out,
                   'screen_time' => $request->screen_time,
                   'food' => $request->food,
                   'sleep' => $request->sleep,
                   'edit' => $request->edit,
                   'to_do_list' => json_encode($request->to_do_list),
                   'daily_dairy' => json_encode($request->daily_dairy),
                   'user_id' => auth()->user()->id,
                ]);
               
                return $this->sendResponse(null, 'Daily dairy updated SuccessFully', true);

            } else {
                $input = $request->except('createdAt','to_do_list','daily_dairy');

                $input['user_id'] = auth()->user()->id;
                $input['to_do_list'] = json_encode($request->to_do_list);
                $input['daily_dairy'] = json_encode($request->daily_dairy);
                $dailydairys = DailyDairy::create($input);

                return $this->sendResponse(null, 'Daily dairy stored SuccessFully', true);
            }

        } catch (\Throwable $th) {

            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function getDailyDiary(Request $request)
    {   
        try {
            $date = isset($request->date) ? $request->date : now()->toDateString();
            $getDairys = DailyDairy::where('user_id',auth()->user()->id)->whereDate('created_at',$date)->get();
           
            if ($getDairys->isEmpty()) {
                return $this->sendResponse(null, 'Data not found', false);
            }

            $getDairyData = [];
        foreach ($getDairys as $dailyDairy) {
            $getDairyData[] = $this->getDailyDairyData($dailyDairy);
        }
                
        return $this->sendResponse($getDairyData, 'Daily dairy retrieved successfully', true);
         
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal server error', false);
        }
    }

    public function getHomePage()
    {
        try {
            $getHome = Home::all();

            return $this->sendResponse($getHome, 'Home page Retrived SuccessFully', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function getDailyDairyData($data){
       
        $datas['id'] = $data->id;
        $datas['user_id'] = $data->id;
        $datas['mood'] = $data->mood;
        $datas['music'] = $data->music;
        $datas['learning'] = $data->learning;
        $datas['cleaning'] = $data->cleaning;
        $datas['body_care'] = $data->body_care;
        $datas['gratitude'] = $data->gratitude;
        $datas['hang_out'] = $data->hang_out;
        $datas['sleep'] = $data->sleep;
        $datas['work_out'] = $data->work_out;
        $datas['screen_time'] = $data->screen_time;
        $datas['food'] = $data->food;
        $datas['edit'] = $data->edit;
        $datas['to_do_list'] = json_decode($data->to_do_list);
        $datas['daily_dairy'] = json_decode($data->daily_dairy);
        $datas['created_at'] = $data->created_at->format('Y-m-d');
    
        return $datas;            
    }

}

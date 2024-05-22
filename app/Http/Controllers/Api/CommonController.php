<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\DailyDairy;
use App\Models\Festival;
use App\Models\Home;
use App\Models\MonthlyMission;
use App\Models\User;
use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function festivalList(Request $request)
    {
        try {

            if(isset($request->language_code) && !empty($request->language_code)){

                $currentMonth = date('m');
                $currentYear = date('Y');
    
                // Filter festivals for the current month
                $festivals = Festival::whereMonth('date', $currentMonth)
                    ->whereYear('date', $currentYear)
                    ->orderBy('date', 'ASC')
                    ->get();
    
                // Extract festival names
                $festivalNames = $festivals->pluck('festival_name_'.$request->language_code)->toArray();
                return $this->sendResponse($festivalNames, 'Festival retrived SuccessFully', true);
            }else{
                return $this->sendResponse(null, 'Language Code not Found!', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeDailydairy(Request $request)
    {
        try {
            $date = isset($request->createdAt) ? $request->createdAt : now()->toDateString();
            $dailydairys = DailyDairy::where('user_id', auth()->user()->id)->whereDate('created_at', $date)->first();
            $carbonDate = Carbon::parse($date);

            if ($dailydairys) {

                $dailydairys->update([
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
                    // 'edit' => $request->edit,
                    'to_do_list' => json_encode($request->to_do_list),
                    'daily_dairy' => json_encode($request->daily_dairy),
                    "is_edit" => $request->is_edit,
                    'created_at' => $date,
                    'updated_at' => $date,
                    'user_id' => auth()->user()->id,
                ]);

                return $this->sendResponse(null, 'Daily dairy updated SuccessFully', true);

            } else {
                $dailydairys = DailyDairy::where('user_id', auth()->user()->id)
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->first();

                $input = $request->except('createdAt', 'to_do_list', 'daily_dairy', 'edit');

                // Check if there are existing entries for the current month and year
                if ($dailydairys && $carbonDate->month == now()->month && $carbonDate->year == now()->year) {
                    // If there are existing entries for the current month and year, get the edit value from the first entry
                    if ($dailydairys->edit != null) {
                        $edit = $dailydairys->edit;
                    } else {
                        $edit = $request->edit;

                        DailyDairy::where('user_id', auth()->user()->id)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->update(['edit' => $edit]);
                    }
                } else {
                    $edit = $request->edit;
                }
                $input['user_id'] = auth()->user()->id;
                $input['to_do_list'] = json_encode($request->to_do_list);
                $input['daily_dairy'] = json_encode($request->daily_dairy);
                $input['edit'] = $edit;
                $input['created_at'] = $date;
                $input['updated_at'] = $date;
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
            $getDairys = DailyDairy::where('user_id', auth()->user()->id)->whereDate('created_at', $date)->get();

            if ($getDairys->isEmpty()) {
                return $this->sendResponse(null, 'Data not found', true);
            }

            foreach ($getDairys as $dailyDairy) {
                $getDairyData = $this->getDailyDairyData($dailyDairy);
            }

            return $this->sendResponse($getDairyData, 'Daily dairy retrieved successfully', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal server error', false);
        }
    }

    public function getDailyDairyData($data)
    {
        $datas['id'] = $data->id;
        $datas['user_id'] = $data->user_id;
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
        $datas['is_edit'] = strval($data->is_edit);
        $datas['created_at'] = $data->created_at->format('Y-m-d');

        return $datas;
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

    public function monthlymission(Request $request)
    {
        try {
            $currentMonth = date('m');

            $monthlyMission = MonthlyMission::whereMonth('created_at', $currentMonth)->where('user_id', auth()->user()->id)->first();

            if ($monthlyMission) {
                $monthlyMission->update([
                    'user_id' => auth()->user()->id,
                    'main_focus_of_month' => json_encode($request->main_focus_of_month),
                    'goals' => json_encode($request->goals),
                    'hobbies' => json_encode($request->hobbies),
                    'habits_to_cut' => json_encode($request->habits_to_cut),
                    'habits_to_adopt' => json_encode($request->habits_to_adopt),
                    'new_things_to_try' => json_encode($request->new_things_to_try),
                    'family_goals' => json_encode($request->family_goals),
                    'books_to_read' => json_encode($request->books_to_read),
                    'movies_to_watch' => json_encode($request->movies_to_watch),
                    'places_to_visit' => json_encode($request->places_to_visit),
                    'make_wish' => $request->make_wish,
                ]);

                return $this->sendResponse(null, 'Monthly Mission Updated Successfully', true);
            } else {

                $monthlyMission = new MonthlyMission;
                $monthlyMission->user_id = auth()->user()->id;
                $monthlyMission->main_focus_of_month = json_encode($request->main_focus_of_month);
                $monthlyMission->goals = json_encode($request->goals);
                $monthlyMission->hobbies = json_encode($request->hobbies);
                $monthlyMission->habits_to_cut = json_encode($request->habits_to_cut);
                $monthlyMission->habits_to_adopt = json_encode($request->habits_to_adopt);
                $monthlyMission->new_things_to_try = json_encode($request->new_things_to_try);
                $monthlyMission->family_goals = json_encode($request->family_goals);
                $monthlyMission->books_to_read = json_encode($request->books_to_read);
                $monthlyMission->movies_to_watch = json_encode($request->movies_to_watch);
                $monthlyMission->places_to_visit = json_encode($request->places_to_visit);
                $monthlyMission->make_wish = $request->make_wish;
                $monthlyMission->save();

                return $this->sendResponse(null, 'Monthly Mission Stored Successfully', true);

            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function getMonthlyMisssion()
    {

        try {
            $currentMonth = date('m');
            $currentYear = date('Y');

            $monthDatas = MonthlyMission::where('user_id', auth()->user()->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->get();

            if ($monthDatas->isEmpty()) {
                return $this->sendResponse(null, 'Data not found', true);
            }

            foreach ($monthDatas as $monthData) {
                $monthAllData = $this->monthMissionGetting($monthData);
            }

            return $this->sendResponse($monthAllData, 'MonthlyMission Data Retrived SuccessFully', true);
        } catch (\Throwable $th) {

            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function monthMissionGetting($data)
    {
        $datas['id'] = $data->id;
        $datas['user_id'] = $data->user_id;
        $datas['main_focus_of_month'] = json_decode($data->main_focus_of_month);
        $datas['goals'] = json_decode($data->goals);
        $datas['hobbies'] = json_decode($data->hobbies);
        $datas['habits_to_cut'] = json_decode($data->habits_to_cut);
        $datas['habits_to_adopt'] = json_decode($data->habits_to_adopt);
        $datas['new_things_to_try'] = json_decode($data->new_things_to_try);
        $datas['family_goals'] = json_decode($data->family_goals);
        $datas['books_to_read'] = json_decode($data->books_to_read);
        $datas['movies_to_watch'] = json_decode($data->movies_to_watch);
        $datas['places_to_visit'] = json_decode($data->places_to_visit);
        $datas['make_wish'] = $data->make_wish;

        return $datas;

    }

    public function getCurrentmonthDailyDairys()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');

            $dailydairys = DailyDairy::where('user_id', auth()->user()->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->orderBy('created_at', 'ASC')
                ->get();

            if ($dailydairys->isEmpty()) {
                return $this->sendResponse(null, 'Data not found', true);
            }

            foreach ($dailydairys as $dailydairy) {
                $monthAllData = $this->getDailyDairyCurrentMonthData($dailydairy);
            }

            return $this->sendResponse($monthAllData, 'Daily Dairy currentMonth Data Retrived SuccessFully', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function getReflectionData()
    {
        try {
            $currentMonth = date('m');
            $currentYear = date('Y');

            $dailydairys = DailyDairy::where('user_id', auth()->user()->id)
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->orderBy('created_at', 'ASC')
                ->get();

            if ($dailydairys->isEmpty()) {
                return $this->sendResponse(null, 'Data not found', true);
            }

            $monthAllData = [];
            foreach ($dailydairys as $dailydairy) {
                $monthAllData[] = $this->getDailyDairyCurrentMonthData($dailydairy);
            }

            return $this->sendResponse($monthAllData, 'Daily Dairy currentMonth Data Retrived SuccessFully', true);

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error', false);
        }
    }

    public function getDailyDairyCurrentMonthData($data)
    {
        $datas['id'] = $data->id;
        $datas['user_id'] = $data->user_id;
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
        $datas['is_edit'] = strval($data->is_edit);
        $datas['created_at'] = date('d M', strtotime($data->created_at));

        $higherGratitudeCount = $this->getGratitudeCounts($data->user_id);
        $higherIsEditCount = $this->getIsEditCounts($data->user_id);

        $datas['isGratitudeComplete'] = $higherGratitudeCount;
        $datas['isEditComplete'] = $higherIsEditCount;
        return $datas;
    }

    public function getGratitudeCounts($userId)
    {
        // Count gratitude values for the given user and date
        $gratitudeCounts = DailyDairy::where('user_id', $userId)
                                     ->whereMonth('created_at', date('m'))
                                     ->whereYear('created_at', date('Y'))
                                     ->select(DB::raw('SUM(gratitude = 0) as count_0'), DB::raw('SUM(gratitude = 1) as count_1'))
                                     ->first();

        $maxCount = max($gratitudeCounts->count_0, $gratitudeCounts->count_1);

        $count0 = $gratitudeCounts->count_0;
        $count1 = $gratitudeCounts->count_1;

       // If both counts are equal, return 1
        if ($count0 === $count1) {
            return 1;
        }

        $mostFrequentGratitude = $count0 >= $count1 ? 0 : 1;

        return $mostFrequentGratitude;
    }

    public function getIsEditCounts($userId)
    {
        // Count gratitude values for the given user and date
        $isEditCounts = DailyDairy::where('user_id', $userId)
                                  ->whereMonth('created_at', date('m'))
                                  ->whereYear('created_at', date('Y'))
                                  ->select(DB::raw('SUM(is_edit = 0) as count_0'), DB::raw('SUM(is_edit = 1) as count_1'))
                                  ->first();

        $maxCount = max($isEditCounts->count_0, $isEditCounts->count_1);

        $count0 = $isEditCounts->count_0;
        $count1 = $isEditCounts->count_1;

        // If both counts are equal, return 1
        if ($count0 === $count1) {
            return 1;
        }

        $mostFrequentIsEdit = $count0 >= $count1 ? 0 : 1;

        return $mostFrequentIsEdit;
    }


}

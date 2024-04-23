<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\MonthlyReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyReminderController extends BaseController
{
    public function storeUserMonthlyReminder(Request $request){
        try {
            $auth_user_id = Auth::user()->id ?? null;
            if($auth_user_id){
                $input = $request->only(['reminder_date','reminder_month','reminder_type','reminder_for']);
                $getUserMonthlyReminder = MonthlyReminder::where('user_id',$auth_user_id)->first();

                if(isset($getUserMonthlyReminder)){
                    $update = $getUserMonthlyReminder->update($input);
                    if ($update) {
                        return $this->sendResponse(null, 'User Monthly Reminder Detail Updated Successfully', true);
                    } else {
                        return $this->sendResponse(null, 'Failed to Update User Monthly Reminder Detail', false);
                    }
                }else{
                    $newMonthlyReminder = new MonthlyReminder();
                    $newMonthlyReminder->user_id = $auth_user_id;
                    $newMonthlyReminder->reminder_date = $request->reminder_date;
                    $newMonthlyReminder->reminder_month = $request->reminder_month;
                    $newMonthlyReminder->reminder_type = $request->reminder_type;
                    $newMonthlyReminder->reminder_for = $request->reminder_for;
                    $newMonthlyReminder->save();

                    return $this->sendResponse(null, 'User Monthly Remainder Detail Stored Successfully', true);
                }

            }else{
                return $this->sendResponse(null,'User Not Found !',false);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }

    public function getStoredUserMonthlyReminder(){
        try {
            $auth_user_id = Auth::user()->id ?? null;
            if($auth_user_id){
                $getUserMonthlyReminder = MonthlyReminder::where('user_id', $auth_user_id)->first();

                if(isset($getUserMonthlyReminder)){
                    return $this->sendResponse($getUserMonthlyReminder, 'User Monthly Reminder Detail Found', true);
                }else{
                    return $this->sendResponse([], 'User Monthly Reminder Not Found', true);
                }
            }else{
                return $this->sendResponse(null, 'User Not Found', false);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null,'Something went wrong!',false);
        }
    }
}

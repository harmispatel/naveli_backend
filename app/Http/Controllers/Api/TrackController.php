<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Ailment;
use App\Models\Medicine;
use App\Models\TrackAilment;
use App\Models\TrackBmiCalculator;
use App\Models\TrackPeriodsMedication;
use App\Models\TrackSleep;
use App\Models\TrackWaterReminder;
use App\Models\TrackWeight;
use Auth;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrackController extends BaseController
{
    public function storeUserMedicationsDetail(Request $request)
    {

        try {
            $user_id = auth()->user()->id;

            $getUserTrackPeriodsMedication = TrackPeriodsMedication::where('user_id', $user_id)->first();

            if (isset($getUserTrackPeriodsMedication)) {

                $update = $getUserTrackPeriodsMedication->update([
                    'user_id' => $user_id,
                    'medicine_id' => json_encode($request->medicine_id),
                    'other_medicine' => isset($request->other_medicine) ? json_encode($request->other_medicine) : null,
                ]);

                return $this->sendResponse(null, 'Data Updated Successfully', true);
            } else {
                $periodMedication = new TrackPeriodsMedication();
                $periodMedication->user_id = auth()->user()->id;
                $periodMedication->medicine_id = json_encode($request->medicine_id);
                $periodMedication->other_medicine = isset($request->other_medicine) ? json_encode($request->other_medicine): null;
                $periodMedication->save();

                return $this->sendResponse(null, 'Data Saved Successfully', true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function getStoredMedicationsDetail(Request $request)
    {
        try {
            $login_user_id = auth()->user()->id;
            $getUserMedicationsDetail = TrackPeriodsMedication::where('user_id', $login_user_id)->first();

            if (isset($getUserMedicationsDetail)) {

                $medicineIds = isset($getUserMedicationsDetail->medicine_id) ? json_decode($getUserMedicationsDetail->medicine_id) : null;
                $otherMedicines = isset($getUserMedicationsDetail->other_medicine) ? json_decode($getUserMedicationsDetail->other_medicine) : null;
                $medicines = Medicine::whereIn('id', $medicineIds)->get();


                $getUserMedicationsDetail->medicine_id = $medicines;
                $getUserMedicationsDetail->other_medicine = $otherMedicines;
                return $this->sendResponse($getUserMedicationsDetail, 'Data Retrived successully', true);

            }

            return $this->sendResponse(null, 'No Data Retrived', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeBmiCalculatorDetail(Request $request)
    {
        try {
            $input = $request->except("_token");

            $login_user_id = auth()->user()->id;
            $getUserBmiCalculationDetail = TrackBmiCalculator::where('user_id', $login_user_id)->first();

            if (isset($getUserBmiCalculationDetail)) {
                $input['user_id'] = auth()->user()->id;
                $update = $getUserBmiCalculationDetail->update($input);
                return $this->sendResponse(null, 'Data Updated Successfully', true);

            } else {
                $input['user_id'] = auth()->user()->id;
                $store_bmi_calculation = TrackBmiCalculator::create($input);
                return $this->sendResponse(null, 'Data Saved Successfully', true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function getStoredBmiCalculatorDetail(){
        try {
            $login_user_id = auth()->user()->id;

            if(!$login_user_id){
                return $this->sendResponse(null, 'User Not Found!', false);
            }else{
                $getStoredBmiCalculatorDetail = TrackBmiCalculator::where('user_id',$login_user_id)->first();

                if(isset($getStoredBmiCalculatorDetail)){
                      $getWeightOfUser = TrackWeight::where('user_id',$login_user_id)->first();
                        if($getStoredBmiCalculatorDetail['weight'] == null){
                            $getStoredBmiCalculatorDetail['weight'] = $getWeightOfUser->weight ?? "";
                        }

                    return $this->sendResponse($getStoredBmiCalculatorDetail, 'User Bmi Calculator Detail Received Successfully', true);
                }else{

                    $getWeightOfUser = TrackWeight::where('user_id',$login_user_id)->first();
                    $getStoredBmiCalculatorDetail['weight'] = $getWeightOfUser->weight ?? "";

                    return $this->sendResponse($getStoredBmiCalculatorDetail, 'Empty Bmi Calculator Detail For This User', true);
                }
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeWeightDetail(Request $request)
    {
        try {
            $input = $request->except("_token");

            $login_user_id = auth()->user()->id;
            $getUserWeightDetail = TrackWeight::where('user_id', $login_user_id)->first();

            if (isset($getUserWeightDetail)) {
                $input['user_id'] = auth()->user()->id;
                $store_weight_detail = $getUserWeightDetail->update($input);
                return $this->sendResponse(null, 'Data Updated Successfully', true);
            } else {
                $input['user_id'] = auth()->user()->id;
                $store_weight_detail = TrackWeight::create($input);
                return $this->sendResponse(null, 'Data Saved Successfully', true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function getStoredWeightDetail(){
        try {
            $login_user_id = auth()->user()->id;

            if(!$login_user_id){
                return $this->sendResponse(null, 'User Not Found!', false);
            }else{
                $getStoredWeightDetail = TrackWeight::where('user_id',$login_user_id)->first();

                if(isset($getStoredWeightDetail)){
                    return $this->sendResponse($getStoredWeightDetail, 'User Weight Detail Received Successfully', true);
                }else{
                    return $this->sendResponse(null, 'Empty Weight Detail For This User', true);
                }
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeUserAilmentsDetail(Request $request)
    {

        try {
            $user_id = auth()->user()->id;

            $getUserAilmentsDetail = TrackAilment::where('user_id', $user_id)->first();

            if (isset($getUserAilmentsDetail)) {

                $update = $getUserAilmentsDetail->update([
                    'user_id' => $user_id,
                    'ailment_id' => json_encode($request->ailment_id),
                    'other_ailments' => isset($request->other_ailments) ? json_encode($request->other_ailments) : null,
                ]);

                return $this->sendResponse(null, 'Data Updated Successfully', true);
            } else {
                $userAilmentsDetail = new TrackAilment();
                $userAilmentsDetail->user_id = $user_id;
                $userAilmentsDetail->ailment_id = json_encode($request->ailment_id);
                $userAilmentsDetail->other_ailments = isset($request->other_ailments) ? json_encode($request->other_ailments) : null;
                $userAilmentsDetail->save();

                return $this->sendResponse(null, 'Data Saved Successfully', true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function getStoredAilmentsDetail()
    {
        try {
            $login_user_id = auth()->user()->id;

            $getUserAilmentsDetail = TrackAilment::where('user_id', $login_user_id)->first();

            if (isset($getUserAilmentsDetail)) {

                $ailmentIds = json_decode($getUserAilmentsDetail->ailment_id);
                $otherAilments = isset($getUserAilmentsDetail->other_ailments) ? json_decode($getUserAilmentsDetail->other_ailments) : null;
                $ailments = Ailment::whereIn('id', $ailmentIds)->get();
                $getUserAilmentsDetail->ailment_id = $ailments->toArray();
                $getUserAilmentsDetail->other_ailments = $otherAilments;

                return $this->sendResponse($getUserAilmentsDetail, 'Data Retrived successully', true);

            }

            return $this->sendResponse(null, 'No Data Retrived', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Internal Server Error!', false);
        }
    }

    public function storeUserSleepDetail(Request $request){
        try {
            $authUserId = auth()->user()->id;
            $today = Carbon::today();

            $getStoredUserSleep = TrackSleep::where('user_id', $authUserId)
                                ->whereDate('created_at', $today)
                                ->first();
            if(isset($getStoredUserSleep)){
                $update = $getStoredUserSleep->update([
                    'bad_time' => $request->bad_time,
                    'wake_up_time' => $request->wake_up_time,
                    'total_sleep_time' => $request->total_sleep_time,
                ]);
                return $this->sendResponse(null, 'User Sleep Detail Updated Successfully', true);
            }else{
                $newSleepDetail = new TrackSleep();
                $newSleepDetail->user_id = $authUserId;
                $newSleepDetail->bad_time = $request->bad_time;
                $newSleepDetail->wake_up_time = $request->wake_up_time;
                $newSleepDetail->total_sleep_time = $request->total_sleep_time;
                $newSleepDetail->save();

                return $this->sendResponse(null, 'User Sleep Detail Stored Successfully', true);
            }

        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function getStoredUserSleepDetail(){
        try {
            $authUserId = auth()->user()->id;
            $today = Carbon::today();

            $getStoredUserSleepDetail = TrackSleep::select('bad_time','wake_up_time','total_sleep_time')
                                        ->where('user_id',$authUserId)
                                        ->whereDate('created_at',$today)
                                        ->first();

            if(isset($getStoredUserSleepDetail)){

                $badTime = DateTime::createFromFormat('h:i a', $getStoredUserSleepDetail->bad_time);
                $wakeUptime = DateTime::createFromFormat('h:i a', $getStoredUserSleepDetail->wake_up_time);

                // Extract bad time hour and minute
                $badTimeHour = (int) $badTime->format('H'); // 24-hour format
                $badTimeMinute = (int) $badTime->format('i');

                // Extract wake up time hour and minute
                $wakeUpTimeHour = (int) $wakeUptime->format('H'); // 24-hour format
                $wakeUpTimeMinute = (int) $wakeUptime->format('i');

                $data = [
                            "bad_time_hours" => $badTimeHour ?? null,
                            "bad_time_minutes" => $badTimeMinute ?? null,
                            "wakeup_time_hours" => $wakeUpTimeHour ?? null,
                            "wakeup_time_minutes" => $wakeUpTimeMinute ?? null,
                            "total_sleep_time" => $getStoredUserSleepDetail->total_sleep_time ?? null,
                            "average_total_sleep_time" => calculateAverageSleepTime($authUserId)
                        ];

                return $this->sendResponse($data, 'User Sleep Detail Received Successfully', true);
            }
            $getStoredUserSleepDetail['average_total_sleep_time'] = calculateAverageSleepTime($authUserId);
            return $this->sendResponse($getStoredUserSleepDetail, 'No Today Sleep Data For This User', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function storeUserWaterReminders(Request $request){
        try {
            $authUserId = auth()->user()->id;
            $today = Carbon::today();

            $getStoredUserWaterReminders = TrackWaterReminder::where('user_id', $authUserId)
            ->whereDate('created_at', $today)
            ->first();

            if(isset($getStoredUserWaterReminders)){
                $update = $getStoredUserWaterReminders->update([
                    'water_ml' => $request->water_ml,
                ]);

                return $this->sendResponse(null, 'User Water Remainder Detail Updated Successfully', true);
            }else{
                $newWaterReminder = new TrackWaterReminder();
                $newWaterReminder->user_id = $authUserId;
                $newWaterReminder->water_ml = $request->water_ml;
                $newWaterReminder->save();

                return $this->sendResponse(null, 'User Water Remainder Detail Stored Successfully', true);
            }
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }

    public function getStoredUserWaterReminders(){
        try {
            $authUserId = auth()->user()->id;
            $today = Carbon::today()->toDateString();
            $getStoredUserWaterReminders = TrackWaterReminder::select('water_ml')
                                        ->where('user_id',$authUserId)
                                        ->whereDate('created_at', $today)
                                        ->first();
            if(isset($getStoredUserWaterReminders)){
                return $this->sendResponse($getStoredUserWaterReminders, 'User Water Reminder Received Successfully', true);
            }
            return $this->sendResponse(null, 'No Water Reminder Detail For This User', true);
        } catch (\Throwable $th) {
            return $this->sendResponse(null, 'Something Went Wrong !', false);
        }
    }
}

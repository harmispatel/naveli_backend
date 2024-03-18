<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Ailment;
use App\Models\Medicine;
use App\Models\TrackAilment;
use App\Models\TrackBmiCalculator;
use App\Models\TrackPeriodsMedication;
use App\Models\TrackWeight;
use Auth;
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

}

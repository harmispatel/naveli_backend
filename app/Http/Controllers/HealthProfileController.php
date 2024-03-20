<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSymptomsLogs;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HealthProfileController extends Controller
{
    public function index()
    {
        return view('admin.healthProfile.healthProfile');
    }

    public function load(Request $request)
    {
        if ($request->ajax()) {

            // 21 to 35 Normal
            $cycle_solo_normal = User::where('relationship_status', 1)->where('role_id', 2)->whereBetween('average_period_length', [21, 35])->count();
            $cycle_solo_irregular = User::where('relationship_status', 1)->where('role_id', 2)->whereNotBetween('average_period_length', [21, 35])->count();
            $cycle_tied_normal = User::where('relationship_status', 2)->where('role_id', 2)->whereBetween('average_period_length', [21, 35])->count();
            $cycle_tied_irregular = User::where('relationship_status', 2)->where('role_id', 2)->whereNotBetween('average_period_length', [21, 35])->count();
            $cycle_ofs_normal = User::where('relationship_status', 3)->where('role_id', 2)->whereBetween('average_period_length', [21, 35])->count();
            $cycle_ofs_irregular = User::where('relationship_status', 3)->where('role_id', 2)->whereNotBetween('average_period_length', [21, 35])->count();
            $cycle_normal_total = $cycle_solo_normal + $cycle_tied_normal + $cycle_ofs_normal;
            $cycle_irregular_total = $cycle_solo_irregular + $cycle_tied_irregular + $cycle_ofs_irregular;

            // 3 to 6 Normal
            $period_solo_normal = User::where('relationship_status', 1)->where('role_id', 2)->whereBetween('average_period_length', [3, 6])->count();
            $period_solo_irregular = User::where('relationship_status', 1)->where('role_id', 2)->whereNotBetween('average_period_length', [3, 6])->count();
            $period_tied_normal = User::where('relationship_status', 2)->where('role_id', 2)->whereBetween('average_period_length', [3, 6])->count();
            $period_tied_irregular = User::where('relationship_status', 2)->where('role_id', 2)->whereNotBetween('average_period_length', [3, 6])->count();
            $period_ofs_normal = User::where('relationship_status', 3)->where('role_id', 2)->whereBetween('average_period_length', [3, 6])->count();
            $period_ofs_irregular = User::where('relationship_status', 3)->where('role_id', 2)->whereNotBetween('average_period_length', [3, 6])->count();
            $period_normal_total = $period_solo_normal + $period_tied_normal + $period_ofs_normal;
            $period_irregular_total = $period_solo_irregular + $period_tied_irregular + $period_ofs_irregular;

            $current_month = Carbon::now()->format('m');
            $first = UserSymptomsLogs::where('working_ability', 1)->whereMonth('created_at', $current_month)->get();
            $count = 0;
            // foreach($first as $key => $f){
            //     if($key == 0){
            //         $count= $count + 1;
            //     }
            // }

            $day_1_almost_never = $count;

            $datas = [
                [
                    'sr' => 1,
                    'title' => 'Cycle Length',
                    'solo_normal' => $cycle_solo_normal,
                    'solo_irregular' => $cycle_solo_irregular,
                    'tied_normal' => $cycle_tied_normal,
                    'tied_irregular' => $cycle_tied_irregular,
                    'ofs_normal' => $cycle_ofs_normal,
                    'ofs_irregular' => $cycle_ofs_irregular,
                    'total_normal' => $cycle_normal_total,
                    'total_irregular' => $cycle_irregular_total,
                ],
                [
                    'sr' => 2,
                    'title' => 'Period Length',
                    'solo_normal' => $period_solo_normal,
                    'solo_irregular' => $period_solo_irregular,
                    'tied_normal' => $period_tied_normal,
                    'tied_irregular' => $period_tied_irregular,
                    'ofs_normal' => $period_ofs_normal,
                    'ofs_irregular' => $period_ofs_irregular,
                    'total_normal' => $period_normal_total,
                    'total_irregular' => $period_irregular_total,
                ],
                [
                    'sr' => 3,
                    'title' => 'Working Ability',
                    'day_1_almost_never' => $day_1_almost_never,
                ]
            ];

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "data"            => $datas
            ]);
        }
    }
}

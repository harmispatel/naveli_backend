<?php

namespace App\Http\Controllers;

use App\Models\User;
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

            $cycle_solo_normal = User::where('relationship_status', 1)->where('role_id', 2)->where('average_cycle_length', 28)->count();
            $cycle_solo_irregular = User::where('relationship_status', 1)->where('role_id', 2)->where('average_cycle_length', '<', 28)->count();
            $cycle_tied_normal = User::where('relationship_status', 2)->where('role_id', 2)->where('average_cycle_length', 28)->count();
            $cycle_tied_irregular = User::where('relationship_status', 2)->where('role_id', 2)->where('average_cycle_length', '<', 28)->count();
            $cycle_ofs_normal = User::where('relationship_status', 3)->where('role_id', 2)->where('average_cycle_length', 28)->count();
            $cycle_ofs_irregular = User::where('relationship_status', 3)->where('role_id', 2)->where('average_cycle_length', '<', 28)->count();
            $cycle_normal_total = $cycle_solo_normal + $cycle_tied_normal + $cycle_ofs_normal;
            $cycle_irregular_total = $cycle_solo_irregular + $cycle_tied_irregular + $cycle_ofs_irregular;

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
                // [
                //     'sr' => 2,
                //     'title' => 'Period Length',
                //     'solo_normal' => 0,
                //     'solo_irregular' => 0,
                //     'tied_normal' => 70,
                //     'tied_irregular' => 30,
                //     'ofs_normal' => 0,
                //     'ofs_irregular' => 0,
                //     'total_normal' => 0,
                //     'total_irregular' => 0,
                // ]
            ];

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "data"            => $datas
            ]);
        }
    }
}

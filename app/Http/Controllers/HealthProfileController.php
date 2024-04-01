<?php

namespace App\Http\Controllers;

use App\Models\TrackBmiCalculator;
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

            // Month & Year Filter
            $month_year = $request->monthYear;
            $month = "";
            $year = "";
            if (!empty($month_year)) {
                $carbon_date = Carbon::createFromFormat('Y-m', $month_year);
                $month = $carbon_date->month;
                $year = $carbon_date->year;
            }

            // Age Group
            $age_group = $request->ageGroup;
            $age_group_start_date = '';
            $age_group_end_date = '';
            $age_group_bod = '';
            if (!empty($age_group) && $age_group != 60) {
                $age_explode = explode('-', $age_group);
                $age_group_start_date = Carbon::now()->subYears($age_explode[1])->toDateString();
                $age_group_end_date = Carbon::now()->subYears($age_explode[0])->toDateString();
            } elseif (!empty($age_group) && $age_group == 60) {
                $age_group_bod = Carbon::now()->subYears(60)->toDateString();
            }

            // Cycle Length (21 to 35 Normal)
            $cycle_solo_normal = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 1)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereBetween('average_cycle_length', [21, 35])->count();
            $cycle_solo_query = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 1)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereNotBetween('average_cycle_length', [21, 35]);
            $cycle_solo_irregular[0] = $cycle_solo_query->count();
            $cycle_solo_irregular[1] = serialize($cycle_solo_query->pluck('id')->toArray());

            $cycle_tied_normal = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 2)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereBetween('average_cycle_length', [21, 35])->count();
            $cycle_tied_query = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 2)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereNotBetween('average_cycle_length', [21, 35]);
            $cycle_tied_irregular[0] = $cycle_tied_query->count();
            $cycle_tied_irregular[1] = serialize($cycle_tied_query->pluck('id')->toArray());

            $cycle_ofs_normal = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 3)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereBetween('average_cycle_length', [21, 35])->count();
            $cycle_ofs_query = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 3)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereNotBetween('average_cycle_length', [21, 35]);
            $cycle_ofs_irregular[0] = $cycle_ofs_query->count();
            $cycle_ofs_irregular[1] = serialize($cycle_ofs_query->pluck('id')->toArray());

            $cycle_normal_total = $cycle_solo_normal + $cycle_tied_normal + $cycle_ofs_normal;
            $cycle_irregular_total[0] = $cycle_solo_irregular[0] + $cycle_tied_irregular[0] + $cycle_ofs_irregular[0];
            $cycle_irregular_total[1] = serialize(array_merge(unserialize($cycle_solo_irregular[1]), unserialize($cycle_tied_irregular[1]), unserialize($cycle_ofs_irregular[1])));



            // Preiod Length (3 to 6 Normal)
            $period_solo_normal = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 1)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereBetween('average_period_length', [3, 6])->count();
            $period_solo_query =  $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 1)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereNotBetween('average_period_length', [3, 6]);
            $period_solo_irregular[0] = $period_solo_query->count();
            $period_solo_irregular[1] = serialize($period_solo_query->pluck('id')->toArray());

            $period_tied_normal = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 2)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereBetween('average_period_length', [3, 6])->count();
            $period_tied_query = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 2)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereNotBetween('average_period_length', [3, 6]);
            $period_tied_irregular[0] = $period_tied_query->count();
            $period_tied_irregular[1] = serialize($period_tied_query->pluck('id')->toArray());

            $period_ofs_normal = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 3)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereBetween('average_period_length', [3, 6])->count();
            $period_ofs_query = $this->CommonConditionsForCycleAndPreiod(User::where('relationship_status', 3)->where('role_id', 2), $age_group_start_date, $age_group_end_date, $age_group_bod)->whereNotBetween('average_period_length', [3, 6]);
            $period_ofs_irregular[0] = $period_ofs_query->count();
            $period_ofs_irregular[1] = serialize($period_ofs_query->pluck('id')->toArray());

            $period_normal_total = $period_solo_normal + $period_tied_normal + $period_ofs_normal;
            $period_irregular_total[0] = $period_solo_irregular[0] + $period_tied_irregular[0] + $period_ofs_irregular[0];
            $period_irregular_total[1] = serialize(array_merge(unserialize($period_solo_irregular[1]), unserialize($period_tied_irregular[1]), unserialize($cycle_ofs_irregular[1])));



            // Working Ability
            // Almost Always (Day-1, Day-2, Day-3)
            $almost_always_arr = $this->commonConditions(UserSymptomsLogs::where('working_ability', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_almost_always = $this->commonCountForWorkingAbility($almost_always_arr, 0);
            $day_2_almost_always = $this->commonCountForWorkingAbility($almost_always_arr, 1);
            $day_3_almost_always = $this->commonCountForWorkingAbility($almost_always_arr, 2);
            // Almost Never (Day-1, Day-2, Day-3)
            $almost_never_arr = $this->commonConditions(UserSymptomsLogs::where('working_ability', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_almost_never = $this->commonCountForWorkingAbility($almost_never_arr, 0);
            $day_2_almost_never = $this->commonCountForWorkingAbility($almost_never_arr, 1);
            $day_3_almost_never = $this->commonCountForWorkingAbility($almost_never_arr, 2);
            // None (Day-1, Day-2, Day-3)
            $none_arr = $this->commonConditions(UserSymptomsLogs::where('working_ability', 4), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_none = $this->commonCountForWorkingAbility($none_arr, 0);
            $day_2_none = $this->commonCountForWorkingAbility($none_arr, 1);
            $day_3_none = $this->commonCountForWorkingAbility($none_arr, 2);



            // Location
            // First (Day-1, Day-2, Day-3)
            $first_arr = $this->commonConditions(UserSymptomsLogs::where('location', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_first = $this->commonCountForWorkingAbility($first_arr, 0);
            $day_2_first = $this->commonCountForWorkingAbility($first_arr, 1);
            $day_3_first = $this->commonCountForWorkingAbility($first_arr, 2);
            // Second (Day-1, Day-2, Day-3)
            $second_arr = $this->commonConditions(UserSymptomsLogs::where('location', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_second = $this->commonCountForWorkingAbility($second_arr, 0);
            $day_2_second = $this->commonCountForWorkingAbility($second_arr, 1);
            $day_3_second = $this->commonCountForWorkingAbility($second_arr, 2);
            // Third (Day-1, Day-2, Day-3)
            $third_arr = $this->commonConditions(UserSymptomsLogs::where('location', 4), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_third = $this->commonCountForWorkingAbility($third_arr, 0);
            $day_2_third = $this->commonCountForWorkingAbility($third_arr, 1);
            $day_3_third = $this->commonCountForWorkingAbility($third_arr, 2);



            // Period Cramps
            // Hurts Little (Day-1, Day-2, Day-3)
            $hurts_little_arr = $this->commonConditions(UserSymptomsLogs::where('cramps', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_hurts_little = $this->commonCountForWorkingAbility($hurts_little_arr, 0);
            $day_2_hurts_little = $this->commonCountForWorkingAbility($hurts_little_arr, 1);
            $day_3_hurts_little = $this->commonCountForWorkingAbility($hurts_little_arr, 2);
            // Hurts More (Day-1, Day-2, Day-3)
            $hurts_more_arr = $this->commonConditions(UserSymptomsLogs::where('cramps', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_hurts_more = $this->commonCountForWorkingAbility($hurts_more_arr, 0);
            $day_2_hurts_more = $this->commonCountForWorkingAbility($hurts_more_arr, 1);
            $day_3_hurts_more = $this->commonCountForWorkingAbility($hurts_more_arr, 2);
            // Hurts Worst (Day-1, Day-2, Day-3)
            $hurts_worst_arr = $this->commonConditions(UserSymptomsLogs::where('cramps', 4), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_hurts_worst = $this->commonCountForWorkingAbility($hurts_worst_arr, 0);
            $day_2_hurts_worst = $this->commonCountForWorkingAbility($hurts_worst_arr, 1);
            $day_3_hurts_worst = $this->commonCountForWorkingAbility($hurts_worst_arr, 2);



            // Collection Method
            // Pads (Day-1, Day-2, Day-3)
            $pads_arr = $this->commonConditions(UserSymptomsLogs::where('collection_method', 1), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_pads = $this->commonCountForWorkingAbility($pads_arr, 0);
            $day_2_pads = $this->commonCountForWorkingAbility($pads_arr, 1);
            $day_3_pads = $this->commonCountForWorkingAbility($pads_arr, 2);
            // Cloth (Day-1, Day-2, Day-3)
            $cloths_arr = $this->commonConditions(UserSymptomsLogs::where('collection_method', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_cloths = $this->commonCountForWorkingAbility($cloths_arr, 0);
            $day_2_cloths = $this->commonCountForWorkingAbility($cloths_arr, 1);
            $day_3_cloths = $this->commonCountForWorkingAbility($cloths_arr, 2);
            // Tampons (Day-1, Day-2, Day-3)
            $tampons_arr = $this->commonConditions(UserSymptomsLogs::where('collection_method', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_tampons = $this->commonCountForWorkingAbility($tampons_arr, 0);
            $day_2_tampons = $this->commonCountForWorkingAbility($tampons_arr, 1);
            $day_3_tampons = $this->commonCountForWorkingAbility($tampons_arr, 2);
            // Cups (Day-1, Day-2, Day-3)
            $cups_arr = $this->commonConditions(UserSymptomsLogs::where('collection_method', 4), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_cups = $this->commonCountForWorkingAbility($cups_arr, 0);
            $day_2_cups = $this->commonCountForWorkingAbility($cups_arr, 1);
            $day_3_cups = $this->commonCountForWorkingAbility($cups_arr, 2);



            // Frequency of Change
            // One Time (Day-1, Day-2, Day-3)
            $one_time_arr = $this->commonConditions(UserSymptomsLogs::where('frequency_of_change_day', 4), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_one_time = $this->commonCountForWorkingAbility($one_time_arr, 0);
            $day_2_one_time = $this->commonCountForWorkingAbility($one_time_arr, 1);
            $day_3_one_time = $this->commonCountForWorkingAbility($one_time_arr, 2);
            // Two Time (Day-1, Day-2, Day-3)
            $two_time_arr = $this->commonConditions(UserSymptomsLogs::where('frequency_of_change_day', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_two_time = $this->commonCountForWorkingAbility($two_time_arr, 0);
            $day_2_two_time = $this->commonCountForWorkingAbility($two_time_arr, 1);
            $day_3_two_time = $this->commonCountForWorkingAbility($two_time_arr, 2);
            // Three Time (Day-1, Day-2, Day-3)
            $three_time_arr = $this->commonConditions(UserSymptomsLogs::where('frequency_of_change_day', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_three_time = $this->commonCountForWorkingAbility($three_time_arr, 0);
            $day_2_three_time = $this->commonCountForWorkingAbility($three_time_arr, 1);
            $day_3_three_time = $this->commonCountForWorkingAbility($three_time_arr, 2);
            // Four Time (Day-1, Day-2, Day-3)
            $four_time_arr = $this->commonConditions(UserSymptomsLogs::where('frequency_of_change_day', 1), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_four_time = $this->commonCountForWorkingAbility($four_time_arr, 0);
            $day_2_four_time = $this->commonCountForWorkingAbility($four_time_arr, 1);
            $day_3_four_time = $this->commonCountForWorkingAbility($four_time_arr, 2);



            // Mood
            // Relaxed (Day-1, Day-2, Day-3)
            $relaxed_arr = $this->commonConditions(UserSymptomsLogs::where('mood', 1), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_relaxed = $this->commonCountForWorkingAbility($relaxed_arr, 0);
            $day_2_relaxed = $this->commonCountForWorkingAbility($relaxed_arr, 1);
            $day_3_relaxed = $this->commonCountForWorkingAbility($relaxed_arr, 2);
            // Iritated (Day-1, Day-2, Day-3)
            $iritated_arr = $this->commonConditions(UserSymptomsLogs::where('mood', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_iritated = $this->commonCountForWorkingAbility($iritated_arr, 0);
            $day_2_iritated = $this->commonCountForWorkingAbility($iritated_arr, 1);
            $day_3_iritated = $this->commonCountForWorkingAbility($iritated_arr, 2);
            // Sad (Day-1, Day-2, Day-3)
            $sad_arr = $this->commonConditions(UserSymptomsLogs::where('mood', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_sad = $this->commonCountForWorkingAbility($sad_arr, 0);
            $day_2_sad = $this->commonCountForWorkingAbility($sad_arr, 1);
            $day_3_sad = $this->commonCountForWorkingAbility($sad_arr, 2);



            // Energy
            // Lively (Day-1, Day-2, Day-3)
            $lively_arr = $this->commonConditions(UserSymptomsLogs::where('energy', 1), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_lively = $this->commonCountForWorkingAbility($lively_arr, 0);
            $day_2_lively = $this->commonCountForWorkingAbility($lively_arr, 1);
            $day_3_lively = $this->commonCountForWorkingAbility($lively_arr, 2);
            // Normal (Day-1, Day-2, Day-3)
            $normal_arr = $this->commonConditions(UserSymptomsLogs::where('energy', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_normal = $this->commonCountForWorkingAbility($normal_arr, 0);
            $day_2_normal = $this->commonCountForWorkingAbility($normal_arr, 1);
            $day_3_normal = $this->commonCountForWorkingAbility($normal_arr, 2);
            // Tired (Day-1, Day-2, Day-3)
            $tired_arr = $this->commonConditions(UserSymptomsLogs::where('energy', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_tired = $this->commonCountForWorkingAbility($tired_arr, 0);
            $day_2_tired = $this->commonCountForWorkingAbility($tired_arr, 1);
            $day_3_tired = $this->commonCountForWorkingAbility($tired_arr, 2);



            // Stress
            // Low (Day-1, Day-2, Day-3)
            $low_arr = $this->commonConditions(UserSymptomsLogs::where('stress', 1), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_low = $this->commonCountForWorkingAbility($low_arr, 0);
            $day_2_low = $this->commonCountForWorkingAbility($low_arr, 1);
            $day_3_low = $this->commonCountForWorkingAbility($low_arr, 2);
            // Moderate (Day-1, Day-2, Day-3)
            $moderate_arr = $this->commonConditions(UserSymptomsLogs::where('stress', 2), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_moderate = $this->commonCountForWorkingAbility($moderate_arr, 0);
            $day_2_moderate = $this->commonCountForWorkingAbility($moderate_arr, 1);
            $day_3_moderate = $this->commonCountForWorkingAbility($moderate_arr, 2);
            // High (Day-1, Day-2, Day-3)
            $high_arr = $this->commonConditions(UserSymptomsLogs::where('stress', 3), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->get()->groupBy('user_id')->toArray();
            $day_1_high = $this->commonCountForWorkingAbility($high_arr, 0);
            $day_2_high = $this->commonCountForWorkingAbility($high_arr, 1);
            $day_3_high = $this->commonCountForWorkingAbility($high_arr, 2);



            // BMI
            // Severely Underweight
            $bmi_severely_underweight = $this->commonConditions(TrackBmiCalculator::where('bmi_type', 'Severely Underweight'), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->count();
            // Underweight
            $bmi_underweight = $this->commonConditions(TrackBmiCalculator::where('bmi_type', 'Underweight'), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->count();
            // Normal Weight
            $bmi_normal_weight = $this->commonConditions(TrackBmiCalculator::where('bmi_type', 'Normal Weight'), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->count();
            // Overweight
            $bmi_over_weight = $this->commonConditions(TrackBmiCalculator::where('bmi_type', 'Overweight'), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->count();
            // Obese
            $bmi_obese = $this->commonConditions(TrackBmiCalculator::where('bmi_type', 'Obese'), $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)->count();
            $total_bmi = $bmi_severely_underweight + $bmi_underweight + $bmi_normal_weight + $bmi_over_weight + $bmi_obese;

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
                    'day_2_almost_never' => $day_2_almost_never,
                    'day_3_almost_never' => $day_3_almost_never,
                    'day_1_almost_always' => $day_1_almost_always,
                    'day_2_almost_always' => $day_2_almost_always,
                    'day_3_almost_always' => $day_3_almost_always,
                    'day_1_none' => $day_1_none,
                    'day_2_none' => $day_2_none,
                    'day_3_none' => $day_3_none,
                ],
                [
                    'sr' => 4,
                    'title' => 'Location',
                    'day_1_first' => $day_1_first,
                    'day_2_first' => $day_2_first,
                    'day_3_first' => $day_3_first,
                    'day_1_second' => $day_1_second,
                    'day_2_second' => $day_2_second,
                    'day_3_second' => $day_3_second,
                    'day_1_third' => $day_1_third,
                    'day_2_third' => $day_2_third,
                    'day_3_third' => $day_3_third,
                ],
                [
                    'sr' => 5,
                    'title' => 'Period Cramps',
                    'day_1_hurts_little' => $day_1_hurts_little,
                    'day_2_hurts_little' => $day_2_hurts_little,
                    'day_3_hurts_little' => $day_3_hurts_little,
                    'day_1_hurts_more' => $day_1_hurts_more,
                    'day_2_hurts_more' => $day_2_hurts_more,
                    'day_3_hurts_more' => $day_3_hurts_more,
                    'day_1_hurts_worst' => $day_1_hurts_worst,
                    'day_2_hurts_worst' => $day_2_hurts_worst,
                    'day_3_hurts_worst' => $day_3_hurts_worst,
                ],
                [
                    'sr' => 6,
                    'title' => 'Collection Method',
                    'day_1_pads' => $day_1_pads,
                    'day_2_pads' => $day_2_pads,
                    'day_3_pads' => $day_3_pads,
                    'day_1_cloths' => $day_1_cloths,
                    'day_2_cloths' => $day_2_cloths,
                    'day_3_cloths' => $day_3_cloths,
                    'day_1_tampons' => $day_1_tampons,
                    'day_2_tampons' => $day_2_tampons,
                    'day_3_tampons' => $day_3_tampons,
                    'day_1_cups' => $day_1_cups,
                    'day_2_cups' => $day_2_cups,
                    'day_3_cups' => $day_3_cups,
                ],
                [
                    'sr' => 7,
                    'title' => 'Frequency of Change',
                    'day_1_one_time' => $day_1_one_time,
                    'day_2_one_time' => $day_2_one_time,
                    'day_3_one_time' => $day_3_one_time,
                    'day_1_two_time' => $day_1_two_time,
                    'day_2_two_time' => $day_2_two_time,
                    'day_3_two_time' => $day_3_two_time,
                    'day_1_three_time' => $day_1_three_time,
                    'day_2_three_time' => $day_2_three_time,
                    'day_3_three_time' => $day_3_three_time,
                    'day_1_four_time' => $day_1_four_time,
                    'day_2_four_time' => $day_2_four_time,
                    'day_3_four_time' => $day_3_four_time,
                ],
                [
                    'sr' => 8,
                    'title' => 'Mood',
                    'day_1_relaxed' => $day_1_relaxed,
                    'day_2_relaxed' => $day_2_relaxed,
                    'day_3_relaxed' => $day_3_relaxed,
                    'day_1_iritated' => $day_1_iritated,
                    'day_2_iritated' => $day_2_iritated,
                    'day_3_iritated' => $day_3_iritated,
                    'day_1_sad' => $day_1_sad,
                    'day_2_sad' => $day_2_sad,
                    'day_3_sad' => $day_3_sad,
                ],
                [
                    'sr' => 9,
                    'title' => 'Energy',
                    'day_1_lively' => $day_1_lively,
                    'day_2_lively' => $day_2_lively,
                    'day_3_lively' => $day_3_lively,
                    'day_1_normal' => $day_1_normal,
                    'day_2_normal' => $day_2_normal,
                    'day_3_normal' => $day_3_normal,
                    'day_1_tired' => $day_1_tired,
                    'day_2_tired' => $day_2_tired,
                    'day_3_tired' => $day_3_tired,
                ],
                [
                    'sr' => 10,
                    'title' => 'Stress',
                    'day_1_low' => $day_1_low,
                    'day_2_low' => $day_2_low,
                    'day_3_low' => $day_3_low,
                    'day_1_moderate' => $day_1_moderate,
                    'day_2_moderate' => $day_2_moderate,
                    'day_3_moderate' => $day_3_moderate,
                    'day_1_high' => $day_1_high,
                    'day_2_high' => $day_2_high,
                    'day_3_high' => $day_3_high,
                ],
                [
                    'sr' => 11,
                    'title' => 'BMI',
                    'bmi_severely_underweight' => $bmi_severely_underweight,
                    'bmi_underweight' => $bmi_underweight,
                    'bmi_normal_weight' => $bmi_normal_weight,
                    'bmi_over_weight' => $bmi_over_weight,
                    'bmi_obese' => $bmi_obese,
                    'total_bmi' => $total_bmi,
                ],
            ];

            return response()->json([
                "draw" => intval($request->request->get('draw')),
                "data" => $datas
            ]);
        }
    }

    public function CommonConditionsForCycleAndPreiod($query, $age_group_start_date, $age_group_end_date, $age_group_bod)
    {
        return $query->when(!empty($age_group_start_date) && !empty($age_group_end_date), function ($query) use ($age_group_start_date, $age_group_end_date) {
            $query->whereBetween('birthdate', [$age_group_start_date, $age_group_end_date]);
        })->when(!empty($age_group_bod), function ($query) use ($age_group_bod) {
            $query->where('birthdate', '<', $age_group_bod);
        });
    }

    public function commonConditions($query, $age_group_start_date, $age_group_end_date, $age_group_bod, $month, $year)
    {
        return $query->when(!empty($age_group_start_date) && !empty($age_group_end_date), function ($query) use ($age_group_start_date, $age_group_end_date) {
            $query->whereHas('user', function ($query) use ($age_group_start_date, $age_group_end_date) {
                $query->whereBetween('birthdate', [$age_group_start_date, $age_group_end_date]);
            });
        })->when(!empty($age_group_bod), function ($query) use ($age_group_bod) {
            $query->whereHas('user', function ($query) use ($age_group_bod) {
                $query->where('birthdate', '<', $age_group_bod);
            });
        })->when(!empty($month) && !empty($year), function ($query) use ($month, $year) {
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        });
    }

    public function commonCountForWorkingAbility($array, $day_key)
    {
        $response = count(array_filter($array, function ($arr) use ($day_key) {
            return isset($arr[$day_key]);
        }));
        return $response;
    }

    public function getHealthProfileUsers($ids)
    {
        try {
            $user_ids = unserialize($ids);
            return view('admin.healthProfile.healthProfileUsers', compact(['user_ids']));
        } catch (\Throwable $th) {
            return redirect()->route('healthProfile')->with('error', 'Oops, Something went wrong!');
        }
    }

    public function loadHealthProfileUsers(Request $request)
    {
        if ($request->ajax()) {

            $user_ids = (isset($request->user_ids) && !empty($request->user_ids)) ? $request->user_ids : [];
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = 'id';
            $dir = 'ASC';
            $search = $request->input('search.value');

            $users = User::whereIn('id', $user_ids)
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('unique_id', 'LIKE', "%{$search}%")
                            ->orWhere('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    });
                })
                ->orderBy($order, $dir)
                ->offset($start)
                ->limit($limit)
                ->get();

            $totalData = User::whereIn('id', $user_ids)->count();
            $totalFiltered = $search ? User::whereIn('id', $user_ids)->where(function ($query) use ($search) {
                $query->where('unique_id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            })->count() : $totalData;

            $datas = $users->map(function ($user) {
                $birthdate = Carbon::parse($user->birthdate);
                $age = $birthdate->diffInYears(Carbon::now());

                if($user->gender == 3 || $user->gender == 4){
                    $gender = "Others";
                }elseif($user->gender == 2){
                    $gender = "Female";
                }else{
                    $gender = "";
                }

                return [
                    'uid' => $user->unique_id,
                    'name' => $user->name,
                    'age' => $age." Years.",
                    'phone' => $user->mobile,
                    'email' => $user->email,
                    'gender' => $gender,
                    'location' => '',
                    'joined_on' => date('d M Y', strtotime($user->created_at)),
                ];
            })->toArray();

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $datas
            ]);
        }
    }
}

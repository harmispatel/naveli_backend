<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard View
    public function index(Request $request)
    {
        try {

            //age Group
            $age_groups = DB::table('question_type_ages')->get();

            $roles = Role::all();

            return view('admin.dashboard.dashboard', compact('age_groups','roles'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function ageGroupWiseCount($ageGroupId, Request $request)
    {

        if ($request->ajax()) {
          
            $startDate = $request->start_date;
            $endDate = $request->end_date;

            // { Neow }
            $totalNeowCount = 0;
            $totalFemaleNeowCount = 0;
            $totalTransNeowCount = 0;

            // { Buddy }
            $totalBuddyCount = 0;
            $totalMaleBuddyCount = 0;
            $totalFemaleBuddyCount = 0;
            $totalTransBuddyCount = 0;

            // { cycle Explorer }
            $totalExplorerCount = 0;
            $totalMaleExplorerCount = 0;
            $totalFemaleExplorerCount = 0;
            $totalTransExplorerCount = 0;

       // Fetch users based on date range if provided, otherwise fetch all users
       $users = isset($startDate) && isset($endDate) ? User::whereBetween('created_at', [$startDate, $endDate])->get() : User::all();
            
            $ageGroup = DB::table('question_type_ages')->where('id', $ageGroupId)->first();

            $users_count = $users->where('role_id', '!=', 1)->count();
            $total_neow = $users->where('role_id', 2)->count();
            $total_buddy = $users->where('role_id', 3)->count();
            $total_cycleExplorer = $users->where('role_id', 4)->count();
            $total_male = $users->where('gender', 1)->where('role_id', '!=', 1)->count();
            $total_female = $users->where('gender', 2)->where('role_id', '!=', 1)->count();
            $total_trans = $users->where('gender', 3)->where('role_id', '!=', 1)->count();

            //relationship status
            $total_solo = $users->where('relationship_status', 1)->where('role_id', '!=', 1)->count();
            $total_tied = $users->where('relationship_status', 2)->where('role_id', '!=', 1)->count();
            $total_ofs = $users->where('relationship_status', 3)->where('role_id', '!=', 1)->count();

            //newo
            $total_neow_female = $users->where('role_id', 2)->where('gender', 2)->count();
            $total_neow_trans = $users->where('role_id', 2)->where('gender', 3)->count();

            //newo active
            $total_neow_active_female = $users->where('role_id', 2)->where('gender', 2)->where('status', 1)->count();
            $total_neow_active_trans = $users->where('role_id', 2)->where('gender', 3)->where('status', 1)->count();

            //buddy
            $total_buddy_male = $users->where('role_id', 3)->where('gender', 1)->count();
            $total_buddy_female = $users->where('role_id', 3)->where('gender', 2)->count();
            $total_buddy_trans = $users->where('role_id', 3)->where('gender', 3)->count();

            //buddy active
            $total_buddy_male = $users->where('role_id', 3)->where('gender', 1)->where('status', 1)->count();
            $total_buddy_female = $users->where('role_id', 3)->where('gender', 2)->where('status', 1)->count();
            $total_buddy_trans = $users->where('role_id', 3)->where('gender', 3)->where('status', 1)->count();

            //cycleExplore
            $total_cycleExplorer_male = $users->where('role_id', 4)->where('gender', 1)->count();
            $total_cycleExplorer_female = $users->where('role_id', 4)->where('gender', 2)->count();
            $total_cycleExplorer_trans = $users->where('role_id', 4)->where('gender', 3)->count();

            //cycleExplore active
            $total_cycleExplorer_male = $users->where('role_id', 4)->where('gender', 1)->where('status', 1)->count();
            $total_cycleExplorer_female = $users->where('role_id', 4)->where('gender', 2)->where('status', 1)->count();
            $total_cycleExplorer_trans = $users->where('role_id', 4)->where('gender', 3)->where('status', 1)->count();

            if ($ageGroupId == 'all') {
                // Neow
                $totalNeowCount = $users->where('role_id', 2)->count();
                $totalFemaleNeowCount = $users->where('role_id', 2)->where('gender', 2)->count();
                $totalTransNeowCount = $users->where('role_id', 2)->where('gender', 3)->count();

                // Buddy
                $totalBuddyCount = $users->where('role_id', 3)->count();
                $totalMaleBuddyCount = $users->where('role_id', 3)->where('gender', 1)->count();
                $totalFemaleBuddyCount = $users->where('role_id', 3)->where('gender', 2)->count();
                $totalTransBuddyCount = $users->where('role_id', 3)->where('gender', 3)->count();

                //  cycle Explorer
                $totalExplorerCount = $users->where('role_id', 4)->count();
                $totalMaleExplorerCount = $users->where('role_id', 4)->where('gender', 1)->count();
                $totalFemaleExplorerCount = $users->where('role_id', 4)->where('gender', 2)->count();
                $totalTransExplorerCount = $users->where('role_id', 4)->where('gender', 3)->count();
            } elseif (!$ageGroup) {
                return response()->json([
                    'totalNeowCount' => 0,
                    'totalFemaleNeowCount' => 0,
                    'totalTransNeowCount' => 0,
                    'totalBuddyCount' => 0,
                    'totalMaleBuddyCount' => 0,
                    'totalFemaleBuddyCount' => 0,
                    'totalTransBuddyCount' => 0,
                    'totalExplorerCount' => 0,
                    'totalMaleExplorerCount' => 0,
                    'totalFemaleExplorerCount' => 0,
                    'totalTransExplorerCount' => 0,
                ]);
            } elseif ($ageGroup) {
               
                $agename = $ageGroup->name; // Example: agename = '10 to 15 year'
                $ageRange = explode(' to ', $agename);
                // Query the users table to count the users with ages within the specified range

                foreach ($users as $user) {
                    $birthdate = $user->birthdate;
                    $age = Carbon::parse($birthdate)->age;
                  
                    if ($ageGroupId == 5) {
                        // Increment counts for users with age greater than 60
                        if ($age > 60) {
                            if ($user->role_id === 2) {
                                $totalNeowCount++;
                                if ($user->gender === 2) { // Female
                                    $totalFemaleNeowCount++;
                                } elseif ($user->gender === 3) { // Trans
                                    $totalTransNeowCount++;
                                }
                            } elseif ($user->role_id === 3) {
                                $totalBuddyCount++;
                                if ($user->gender === 1) { // Male
                                    $totalMaleBuddyCount++;
                                } elseif ($user->gender === 2) { // Female
                                    $totalFemaleBuddyCount++;
                                } elseif ($user->gender === 3) { // Trans
                                    $totalTransBuddyCount++;
                                }
                            } elseif ($user->role_id === 4) {
                                $totalExplorerCount++;
                                if ($user->gender === 1) { // Male
                                    $totalMaleExplorerCount++;
                                } elseif ($user->gender === 2) { // Female
                                    $totalFemaleExplorerCount++;
                                } elseif ($user->gender === 3) { // Trans
                                    $totalTransExplorerCount++;
                                }
                            }
                        }
                    } else {

                        // { Neow }
                        // Check if the user's age falls within the specified range
                        if ($age >= $ageRange[0] && $age <= $ageRange[1] && $user->role_id === 2) {
                            // Increment total count
                            $totalNeowCount++;

                            // Increment gender-specific count based on user's gender and role
                            if ($user->gender === 2) { // Assuming 2 is for female
                                $totalFemaleNeowCount++;
                            } elseif ($user->gender === 3) { // Assuming 3 is for trans
                                $totalTransNeowCount++;
                            }
                        }

                        // { Buddy }
                        // Check if the user's age falls within the specified range
                        if ($age >= $ageRange[0] && $age <= $ageRange[1] && $user->role_id === 3) {
                            // Increment total count
                            $totalBuddyCount++;

                            // Increment gender-specific count based on user's gender and role
                            if ($user->gender === 1) { // Assuming 1 is for male
                                $totalMaleBuddyCount++;
                            } elseif ($user->gender === 2) { // Assuming 2 is for female
                                $totalFemaleBuddyCount++;
                            } elseif ($user->gender === 3) { // Assuming 3 is for trans
                                $totalTransBuddyCount++;
                            }
                        }

                        // { cycle Explorer }
                        // Check if the user's age falls within the specified range
                        if ($age >= $ageRange[0] && $age <= $ageRange[1] && $user->role_id === 4) {
                            // Increment total count
                            $totalExplorerCount++;

                            // Increment gender-specific count based on user's gender and role
                            if ($user->gender === 1) { // Assuming 1 is for male
                                $totalMaleExplorerCount++;
                            } elseif ($user->gender === 2) { // Assuming 2 is for female
                                $totalFemaleExplorerCount++;
                            } elseif ($user->gender === 3) { // Assuming 3 is for trans
                                $totalTransExplorerCount++;
                            }
                        }

                    }

                }
            }

            return response()->json([
                'users_count' => $users_count,
                'total_neow' => $total_neow,
                'total_buddy' => $total_buddy,
                'total_cycleExplorer' => $total_cycleExplorer,
                'total_male' => $total_male,
                'total_female' => $total_female,
                'total_trans' => $total_trans,

                'total_neow_female' => $total_neow_female,
                'total_neow_trans' => $total_neow_trans,

                'total_buddy_male' => $total_buddy_male,
                'total_buddy_female' => $total_buddy_female,
                'total_buddy_trans' => $total_buddy_trans,

                'total_cycleExplorer_male' => $total_cycleExplorer_male,
                'total_cycleExplorer_female' => $total_cycleExplorer_female,
                'total_cycleExplorer_trans' => $total_cycleExplorer_trans,

                'total_solo' => $total_solo,
                'total_tied' => $total_tied,
                'total_ofs' => $total_ofs,

                // { Neow }
                'totalNeowCount' => $totalNeowCount,
                'totalFemaleNeowCount' => $totalFemaleNeowCount,
                'totalTransNeowCount' => $totalTransNeowCount,

                // { Buddy }
                'totalBuddyCount' => $totalBuddyCount,
                'totalMaleBuddyCount' => $totalMaleBuddyCount,
                'totalFemaleBuddyCount' => $totalFemaleBuddyCount,
                'totalTransBuddyCount' => $totalTransBuddyCount,

                // { cycle Explorer }
                'totalExplorerCount' => $totalExplorerCount,
                'totalMaleExplorerCount' => $totalMaleExplorerCount,
                'totalFemaleExplorerCount' => $totalFemaleExplorerCount,
                'totalTransExplorerCount' => $totalTransExplorerCount,
            ]);
        }

    }

    // public function ageGroupWiseCount($ageGroupId, Request $request)
    // {
    //     if($request->ajax()){
    //         $startDate = $request->start_date;
    //         $endDate = $request->end_date;

    //         // { Neow }
    //         $totalNeowCount = 0;
    //         $totalFemaleNeowCount = 0;
    //         $totalTransNeowCount = 0;

    //         // { Buddy }
    //         $totalBuddyCount = 0;
    //         $totalMaleBuddyCount = 0;
    //         $totalFemaleBuddyCount = 0;
    //         $totalTransBuddyCount = 0;

    //         // { cycle Explorer }
    //         $totalExplorerCount = 0;
    //         $totalMaleExplorerCount = 0;
    //         $totalFemaleExplorerCount = 0;
    //         $totalTransExplorerCount = 0;

    //         // Retrieve users based on the selected date range
    //         $users = User::whereBetween('created_at', [$startDate, $endDate])->get();

    //         // Check if the selected age group is 'all'
    //         if ($ageGroupId == 'all') {

    //              // Neow
    //         $totalNeowCount = $users->where('role_id', 2)->count();

    //         $totalFemaleNeowCount = $users->where('role_id', 2)->where('gender', 2)->count();
    //         $totalTransNeowCount = $users->where('role_id', 2)->where('gender', 3)->count();

    //         // Buddy
    //         $totalBuddyCount = $users->where('role_id', 3)->count();
    //         $totalMaleBuddyCount = $users->where('role_id', 3)->where('gender', 1)->count();
    //         $totalFemaleBuddyCount = $users->where('role_id', 3)->where('gender', 2)->count();
    //         $totalTransBuddyCount = $users->where('role_id', 3)->where('gender', 3)->count();

    //         //  cycle Explorer
    //         $totalExplorerCount = $users->where('role_id', 4)->count();
    //         $totalMaleExplorerCount = $users->where('role_id', 4)->where('gender', 1)->count();
    //         $totalFemaleExplorerCount = $users->where('role_id', 4)->where('gender', 2)->count();
    //         $totalTransExplorerCount = $users->where('role_id', 4)->where('gender', 3)->count();
    //             // Your existing logic goes here...
    //         } else {
    //             // Retrieve age group details
    //             $ageGroup = DB::table('question_type_ages')->where('id', $ageGroupId)->first();

    //             // Check if the age group exists
    //             if (!$ageGroup) {
    //                 return response()->json([
    //                     'totalNeowCount' => 0,
    //                     'totalFemaleNeowCount' => 0,
    //                     'totalTransNeowCount' => 0,
    //                     'totalBuddyCount' => 0,
    //                     'totalMaleBuddyCount' => 0,
    //                     'totalFemaleBuddyCount' => 0,
    //                     'totalTransBuddyCount' => 0,
    //                     'totalExplorerCount' => 0,
    //                     'totalMaleExplorerCount' => 0,
    //                     'totalFemaleExplorerCount' => 0,
    //                     'totalTransExplorerCount' => 0,
    //                 ]);
    //             }

    //             // Extract age range from the age group details
    //             $ageRange = explode(' to ', $ageGroup->name);

    //             // Loop through users to count based on the selected age range
    //             foreach ($users as $user) {
    //                 $birthdate = $user->birthdate;
    //                 $age = Carbon::parse($birthdate)->age;

    //                 // Check if the user's age falls within the specified range and role
    //                 if ($age >= $ageRange[0] && $age <= $ageRange[1]) {
    //                     if ($user->role_id === 2) { // Neow
    //                         $totalNeowCount++;
    //                         if ($user->gender === 2) { // Female
    //                             $totalFemaleNeowCount++;
    //                         } elseif ($user->gender === 3) { // Trans
    //                             $totalTransNeowCount++;
    //                         }
    //                     } elseif ($user->role_id === 3) { // Buddy
    //                         $totalBuddyCount++;
    //                         if ($user->gender === 1) { // Male
    //                             $totalMaleBuddyCount++;
    //                         } elseif ($user->gender === 2) { // Female
    //                             $totalFemaleBuddyCount++;
    //                         } elseif ($user->gender === 3) { // Trans
    //                             $totalTransBuddyCount++;
    //                         }
    //                     } elseif ($user->role_id === 4) { // Cycle Explorer
    //                         $totalExplorerCount++;
    //                         if ($user->gender === 1) { // Male
    //                             $totalMaleExplorerCount++;
    //                         } elseif ($user->gender === 2) { // Female
    //                             $totalFemaleExplorerCount++;
    //                         } elseif ($user->gender === 3) { // Trans
    //                             $totalTransExplorerCount++;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         // Return JSON response with the counts
    //         return response()->json([
    //             'totalNeowCount' => $totalNeowCount,
    //             'totalFemaleNeowCount' => $totalFemaleNeowCount,
    //             'totalTransNeowCount' => $totalTransNeowCount,
    //             'totalBuddyCount' => $totalBuddyCount,
    //             'totalMaleBuddyCount' => $totalMaleBuddyCount,
    //             'totalFemaleBuddyCount' => $totalFemaleBuddyCount,
    //             'totalTransBuddyCount' => $totalTransBuddyCount,
    //             'totalExplorerCount' => $totalExplorerCount,
    //             'totalMaleExplorerCount' => $totalMaleExplorerCount,
    //             'totalFemaleExplorerCount' => $totalFemaleExplorerCount,
    //             'totalTransExplorerCount' => $totalTransExplorerCount,
    //         ]);
    //     }
    // }

    // Admin Logout
    public function adminLogout()
    {
        try {
            Auth::logout();
            session()->forget('is_verified');
            session()->flush();
            return redirect()->route('admin.login');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}

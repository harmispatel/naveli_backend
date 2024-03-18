<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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

            $users_count = User::where('role_id', '!=', 1)->count();
            $total_neow = User::where('role_id', 2)->count();
            $total_buddy = User::where('role_id', 3)->count();
            $total_cycleExplorer = User::where('role_id', 4)->count();
            $total_male = User::where('gender', 1)->where('role_id', '!=', 1)->count();
            $total_female = User::where('gender', 2)->where('role_id', '!=', 1)->count();
            $total_trans = User::where('gender', 3)->where('role_id', '!=', 1)->count();

            //newo
            $total_neow_female = User::where('role_id', 2)->where('gender', 2)->count();
            $total_neow_trans = User::where('role_id', 2)->where('gender', 3)->count();

            //newo active
            $total_neow_active_female = User::where('role_id', 2)->where('gender', 2)->where('status', 1)->count();
            $total_neow_active_trans = User::where('role_id', 2)->where('gender', 3)->where('status', 1)->count();

            //buddy
            $total_buddy_male = User::where('role_id', 3)->where('gender', 1)->count();
            $total_buddy_female = User::where('role_id', 3)->where('gender', 2)->count();
            $total_buddy_trans = User::where('role_id', 3)->where('gender', 3)->count();

            //buddy active
            $total_buddy_male = User::where('role_id', 3)->where('gender', 1)->where('status', 1)->count();
            $total_buddy_female = User::where('role_id', 3)->where('gender', 2)->where('status', 1)->count();
            $total_buddy_trans = User::where('role_id', 3)->where('gender', 3)->where('status', 1)->count();

            //cycleExplore
            $total_cycleExplorer_male = User::where('role_id', 4)->where('gender', 1)->count();
            $total_cycleExplorer_female = User::where('role_id', 4)->where('gender', 2)->count();
            $total_cycleExplorer_trans = User::where('role_id', 4)->where('gender', 3)->count();

            //cycleExplore active
            $total_cycleExplorer_male = User::where('role_id', 4)->where('gender', 1)->where('status', 1)->count();
            $total_cycleExplorer_female = User::where('role_id', 4)->where('gender', 2)->where('status', 1)->count();
            $total_cycleExplorer_trans = User::where('role_id', 4)->where('gender', 3)->where('status', 1)->count();

            //age Group
            $age_groups = DB::table('question_type_ages')->get();

            //relationship status
            $total_solo = User::where('relationship_status', 1)->where('role_id', '!=', 1)->count();
            $total_tied = User::where('relationship_status', 2)->where('role_id', '!=', 1)->count();
            $total_ofs = User::where('relationship_status', 3)->where('role_id', '!=', 1)->count();

            return view('admin.dashboard.dashboard', compact('users_count', 'total_neow', 'total_buddy', 'total_cycleExplorer', 'total_neow_female', 'total_neow_trans', 'total_buddy_male', 'total_buddy_female', 'total_buddy_trans', 'total_cycleExplorer_male', 'total_cycleExplorer_female', 'total_cycleExplorer_trans', 'age_groups', 'total_male', 'total_female', 'total_trans', 'total_solo', 'total_tied', 'total_ofs'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    // public function ageGroupWiseCount($ageGroupId) {
    //     $totalCount = 0;
    //     $totalFemaleCount = 0;
    //     $totalTransCount = 0;

    //     $ageGroup = DB::table('question_type_ages')->where('id', $ageGroupId)->first();

    //     $currentYear = Carbon::now()->year;

    //     // Query the users table to count the users with a birthdate in the current year
    //     $users = User::all();

    //     // Initialize an empty array to store ages
    //     $ages = [];

    //     // Iterate over each user to calculate age
    //     foreach ($users as $user) {
    //         $birthdate = $user->birthdate;
    //         $age = Carbon::parse($birthdate)->age;
    //         $ages[] = $age; // Store age in the array
    //     }

    //     if ($ageGroup) {
    //         $agename = $ageGroup->name; // Example: agename = '10 to 15 year'

    //         $ageRange = explode(' to ', $agename);

    //     }

    //     return response()->json([
    //         'totalCount' => $totalCount,
    //         'totalFemaleCount' => $totalFemaleCount,
    //         'totalTransCount' => $totalTransCount,
    //     ]);
    // }

    public function ageGroupWiseCount($ageGroupId)
    {  
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

        $ageGroup = DB::table('question_type_ages')->where('id', $ageGroupId)->first();
        $users = User::all();

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

    // Admin Logout
    public function adminLogout()
    {
        try {
            Auth::logout();
            session()->flush();
            return redirect()->route('admin.login');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Exports\ActiveUserExport;
use App\Exports\UserNBCExport;
use App\Exports\UserGenderExport;
use App\Exports\UserRelationExport;
use App\Exports\UserAgeGroupExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivityStatus;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{

    public function download(Request $request)
    {
        
        try {
            if ($request->ajax()) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                $userCount = $request->user_count;
                $ageGroupId = $request->ageGroupId;

                //neow
                $ageTotalNeow = $request->ageTotalNeow;
                $ageNeowFemale = $request->ageNeowFemale;
                $ageNeowTrans = $request->ageNeowTrans;

                //buddy
                $ageTotalBuddy = $request->ageTotalBuddy;
                $ageBuddyMale = $request->ageBuddyMale;
                $ageBuddyFemale = $request->ageBuddyFemale;
                $ageBuddyTrans = $request->ageBuddyTrans;

                //Explore
                $ageTotalExplore = $request->ageTotalExplore;
                $ageExploreMale = $request->ageExploreMale;
                $ageExploreFemale = $request->ageExploreFemale;
                $ageExploreTrans = $request->ageExploreTrans;

                //totalAgeCount
                $totalAgeGroupCount = $request->totalAgeGroupCount; 
             
                $ageGroup = DB::table('question_type_ages')->where('id',$ageGroupId)->first();
          
                if($ageGroupId == 5){
                    $ageGroupName = "more than 60 Year";
                }elseif($ageGroupId == 'all'){
                    $ageGroupName = "All"; 
                }elseif($ageGroupId == $ageGroup->id){
                    $ageGroupName = $ageGroup->name . ' Year';
                }

                // Generate the file and store it
                return Excel::download(new UsersExport($startDate, $endDate, $userCount, $ageGroupName, $ageTotalNeow, $ageNeowFemale, $ageNeowTrans, $ageTotalBuddy, $ageBuddyMale, $ageBuddyFemale, $ageBuddyTrans, $ageTotalExplore, $ageExploreMale, $ageExploreFemale,
                $ageExploreTrans, $totalAgeGroupCount), 'users.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (\Exception $e) {
           
            // Log the error
            \Log::error('Error exporting users: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error exporting users'], 500);
        }
    }

    public function downloadAgeGroup(Request $request)
    {       
        try {
            if ($request->ajax()) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                $userCount = $request->user_count;
                $ageGroupId = $request->ageGroupId;

                //neow
                $ageTotalNeow = $request->ageTotalNeow;
                $ageNeowFemale = $request->ageNeowFemale;
                $ageNeowTrans = $request->ageNeowTrans;

                //buddy
                $ageTotalBuddy = $request->ageTotalBuddy;
                $ageBuddyMale = $request->ageBuddyMale;
                $ageBuddyFemale = $request->ageBuddyFemale;
                $ageBuddyTrans = $request->ageBuddyTrans;

                //Explore
                $ageTotalExplore = $request->ageTotalExplore;
                $ageExploreMale = $request->ageExploreMale;
                $ageExploreFemale = $request->ageExploreFemale;
                $ageExploreTrans = $request->ageExploreTrans;

                //totalAgeCount
                $totalAgeGroupCount = $request->totalAgeGroupCount; 
             
                $ageGroup = DB::table('question_type_ages')->where('id',$ageGroupId)->first();
          
                if($ageGroupId == 5){
                    $ageGroupName = "more than 60 Year";
                }elseif($ageGroupId == 'all'){
                    $ageGroupName = "All"; 
                }elseif($ageGroupId == $ageGroup->id){
                    $ageGroupName = $ageGroup->name . ' Year';
                }

                // Generate the file and store it
                return Excel::download(new UserAgeGroupExport($startDate, $endDate, $userCount, $ageGroupName, $ageTotalNeow, $ageNeowFemale, $ageNeowTrans, $ageTotalBuddy, $ageBuddyMale, $ageBuddyFemale, $ageBuddyTrans, $ageTotalExplore, $ageExploreMale, $ageExploreFemale,
                $ageExploreTrans, $totalAgeGroupCount), 'usersAgeGroup.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error exporting users: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error exporting users'], 500);
        }
    }

    public function downloadUserRelation(Request $request)
    {
        
        try {
            if ($request->ajax()) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                $userCount = $request->user_count;

                // Generate the file and store it
                return Excel::download(new UserRelationExport($startDate, $endDate, $userCount), 'usersRelation.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (\Exception $e) {
           
            // Log the error
            \Log::error('Error exporting users: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error exporting users'], 500);
        }
    }

    public function downloadActiveUsers(Request $request)
    {
        
        try {
            if ($request->ajax()) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                $userCount = $request->user_count;

                // Generate the file and store it
                return Excel::download(new ActiveUserExport($startDate, $endDate, $userCount), 'activeUsers.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (\Exception $e) {
           dd($e);
            // Log the error
            \Log::error('Error exporting users: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error exporting users'], 500);
        }
    }

    public function downloadUserGender(Request $request)
    {
        try {
            if ($request->ajax()) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                $userCount = $request->user_count;
              
                // Generate the file and store it
                return Excel::download(new UserGenderExport($startDate, $endDate, $userCount), 'usersGender.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (\Exception $e) {
            // Log the error

            \Log::error('Error exporting users: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error exporting users'], 500);
        }
    }

    public function downloadNBC(Request $request)
    {
        
        try {
            if ($request->ajax()) {
                $startDate = $request->start_date;
                $endDate = $request->end_date;
                $userCount = $request->user_count;
              
                // Generate the file and store it
                return Excel::download(new UserNBCExport($startDate, $endDate, $userCount), 'usersNBC.xlsx', null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (\Exception $e) {
           dd($e);
            // Log the error

            \Log::error('Error exporting users: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error exporting users'], 500);
        }
    }

    // Dashboard View
    public function index(Request $request)
    {
        try {

            //age Group
            $age_groups = DB::table('question_type_ages')->get();

            $roles = Role::all();

            return view('admin.dashboard.dashboard', compact('age_groups', 'roles'));
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

            // { active users }
            $totalMaleActiveUsers = 0;  
            $totalFemaleActiveUsers = 0;
            $totalTransActiveUsers = 0;

            $totalAgeGroupCount = 0;

            // Fetch users based on date range if provided, otherwise fetch all users
            if (isset($startDate) && isset($endDate) && $startDate != $endDate) {
                $users = User::whereBetween('created_at', [$startDate, $endDate])->get();

                $activeUsers = UserActivityStatus::with('user')
                ->whereBetween('created_at',[$startDate,$endDate])
                ->where('activity_counts', '>=', 15)
                ->get();
            } else {
                $users = User::all();
                $activeUsers = UserActivityStatus::with('user') 
                ->where('activity_counts', '>=', 15)
                ->get();
            }

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

            // activeUsers
            $totalMaleActiveUsers = $activeUsers->where('user.gender', 1)->count();
            $totalFemaleActiveUsers = $activeUsers->where('user.gender', 2)->count();
            $totalTransActiveUsers = $activeUsers->where('user.gender', 3)->count();

            if ($ageGroupId == 'all') {
                //AgeGrouptotalCount

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
                    'totalAgeGroupCount'=> 0,
                    'totalMaleActiveUsers' => 0,
                    'totalFemaleActiveUsers' => 0,
                    'totalTransActiveUsers' => 0,
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
                        if ($age >= $ageRange[0] && $age <= $ageRange[1]) {

                            if($user->role_id === 2){
                                // Increment total count
                                $totalNeowCount++;
                                // Increment gender-specific count based on user's gender and role
                                if ($user->gender === 2) { // Assuming 2 is for female
                                    $totalFemaleNeowCount++;
                                } elseif ($user->gender === 3) { // Assuming 3 is for trans
                                    $totalTransNeowCount++;
                                }
                            }
                          
                        }

                        // { Buddy }
                        // Check if the user's age falls within the specified range
                        if ($age >= $ageRange[0] && $age <= $ageRange[1]) {
                            
                            if($user->role_id === 3){
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
                           
                        }

                        // { cycle Explorer }
                        // Check if the user's age falls within the specified range
                        if ($age >= $ageRange[0] && $age <= $ageRange[1]) {

                            if($user->role_id === 4){
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
            }

            $totalAgeGroupCount = $totalNeowCount + $totalBuddyCount + $totalExplorerCount;

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

                // { activeUsers}
                 'totalMaleActiveUsers' => $totalMaleActiveUsers,
                 'totalFemaleActiveUsers' => $totalFemaleActiveUsers,
                 'totalTransActiveUsers' => $totalTransActiveUsers,
    
                //ageGroupTotalCount
                'totalAgeGroupCount' => $totalAgeGroupCount,
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

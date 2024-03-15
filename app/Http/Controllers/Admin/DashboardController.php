<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard View
    public function index(Request $request)
    {
        try{
            if($request->ajax()){
                dd('hy');
            }
            $users_count = User::where('role_id','!=',1)->count();
            $total_neow =  User::where('role_id',2)->count();
            $total_buddy =  User::where('role_id',3)->count();
            $total_cycleExplorer =  User::where('role_id',4)->count();
            $total_male = User::where('gender',1)->count();
            $total_female = User::where('gender',2)->count();
            $total_trans = User::where('gender',3)->count();

            //newo
            $total_neow_female = User::where('role_id',2)->where('gender',2)->count();
            $total_neow_trans = User::where('role_id',2)->where('gender',3)->count();

                //newo active
                $total_neow_active_female = User::where('role_id',2)->where('gender',2)->where('status',1)->count();
                $total_neow_active_trans = User::where('role_id',2)->where('gender',3)->where('status',1)->count();

            //buddy
            $total_buddy_male = User::where('role_id',3)->where('gender',1)->count();
            $total_buddy_female = User::where('role_id',3)->where('gender',2)->count();
            $total_buddy_trans = User::where('role_id',3)->where('gender',3)->count();

                //buddy active
                $total_buddy_male = User::where('role_id',3)->where('gender',1)->where('status',1)->count();
                $total_buddy_female = User::where('role_id',3)->where('gender',2)->where('status',1)->count();
                $total_buddy_trans = User::where('role_id',3)->where('gender',3)->where('status',1)->count();

            //cycleExplore
            $total_cycleExplorer_male = User::where('role_id',4)->where('gender',1)->count();
            $total_cycleExplorer_female = User::where('role_id',4)->where('gender',2)->count();
            $total_cycleExplorer_trans = User::where('role_id',4)->where('gender',3)->count();

                //cycleExplore active
                $total_cycleExplorer_male = User::where('role_id',4)->where('gender',1)->where('status',1)->count();
                $total_cycleExplorer_female = User::where('role_id',4)->where('gender',2)->where('status',1)->count();
                $total_cycleExplorer_trans = User::where('role_id',4)->where('gender',3)->where('status',1)->count();
                  
            //age Group
               $age_groups = DB::table('question_type_ages')->get();

            //relationship status
            $total_solo = User::where('relationship_status',1)->count();
            $total_tied = User::where('relationship_status',2)->count();
            $total_ofs = User::where('relationship_status',3)->count();
              
            return view('admin.dashboard.dashboard',compact('users_count','total_neow','total_buddy','total_cycleExplorer','total_neow_female','total_neow_trans','total_buddy_male','total_buddy_female','total_buddy_trans','total_cycleExplorer_male','total_cycleExplorer_female','total_cycleExplorer_trans','age_groups','total_male','total_female','total_trans','total_solo','total_tied','total_ofs'));
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function ageGroupWiseCount($ageGroupId) {
        $totalCount = 0;
        $totalFemaleCount = 0;
        $totalTransCount = 0;
    
        $ageGroup = DB::table('question_type_ages')->where('id', $ageGroupId)->first();
       
        $currentYear = Carbon::now()->year;

        // Query the users table to count the users with a birthdate in the current year
        $users = User::all();
    
        // Initialize an empty array to store ages
        $ages = [];
        
        // Iterate over each user to calculate age
        foreach ($users as $user) {
            $birthdate = $user->birthdate;
            $age = Carbon::parse($birthdate)->age;
            $ages[] = $age; // Store age in the array
           
        }
        dd($ages);


        if ($ageGroup) {
            $agename = $ageGroup->name; // Example: agename = '10 to 15 year'
  
            $ageRange = explode(' to ', $agename);
                   
            if (count($ageRange) === 2) {



                // Calculate the start and end birthdates for the age range
                $endBirthdate = Carbon::now()->subYears($ageRange[0])->endOfDay();
                dd($endBirthdate);
                $startBirthdate = Carbon::now()->subYears($ageRange[1])->startOfDay();
    
                // Query the user table to get the count of users within the specified age range
                $totalCount = User::whereBetween('birthdate', [$startBirthdate, $endBirthdate])->count();
                $totalFemaleCount = User::where('gender', '2')->whereBetween('birthdate', [$startBirthdate, $endBirthdate])->count();
                $totalTransCount = User::where('gender', '3')->whereBetween('birthdate', [$startBirthdate, $endBirthdate])->count();
            }
        }
    
        return response()->json([
            'totalCount' => $totalCount,
            'totalFemaleCount' => $totalFemaleCount,
            'totalTransCount' => $totalTransCount,
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

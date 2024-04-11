<?php

use App\Models\TrackSleep;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

 function getRoleList(){

       $roles = Role::where('id','!=','1')->get();
       return $roles;
 }

function uuId($role_id,$gender_id) {
    // Get the role detail based on the role ID
    $role = Role::find($role_id);
    $starting_count_no = 100000;
    // Determine the prefix based on the role
    $prefix_role = '';
    switch ($role->id) {
        case '2':
            $prefix_role = 'N';
            break;
        case '3':
            $prefix_role = 'B';
            break;
        case '4':
            $prefix_role = 'C';
            break;
        default:
            $prefix_role = 'D';
    }

    $prefix_gender = '';
    switch($gender_id){

        case '1':
            $prefix_gender = 'M';
            break;
        case '2':
            $prefix_gender = 'F';
            break;
        case '3':
            $prefix_gender = 'T';
            break;
        case '4':
            $prefix_gender = 'O';
            break;
        default:
            $prefix_gender = 'D';
    }
    // Generate a unique number
    $nextId = $starting_count_no + (User::count() + 1);
    $uniqueId = $prefix_role . $prefix_gender . $nextId;

    do {
        $userWithSameId = User::where('unique_id', $uniqueId)->first();
        if ($userWithSameId) {
            $nextId++;
            $uniqueId = $prefix_role . $prefix_gender . $nextId;
        }
    } while ($userWithSameId);

    return $uniqueId;
}

function calculateAge($birthdate)
{
    $birthDate = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birthDate)->y;
    return $age;
}

function calculateAverageSleepTime($userId) {

    $records = TrackSleep::where('user_id', $userId)
        ->whereBetween('created_at', [now()->subWeek(), now()])
        ->get();


    $totalSeconds = 0;
    $recordCount = $records->count();


    foreach ($records as $record) {

        $badTime = DateTime::createFromFormat('h:i a', $record->bad_time);
        $wakeUptime = DateTime::createFromFormat('h:i a', $record->wake_up_time);
        // If end time is before start time, it's on the next day
        if ($wakeUptime < $badTime) {
            // Add one day to end time
            $wakeUptime->modify('+1 day');
        }
         $difference  = $wakeUptime->diff($badTime);
         $totalSeconds += $difference->s + ($difference->i * 60) + ($difference->h * 3600);

    }

    // Calculate average sleep time
    if ($recordCount > 0) {
        $averageSeconds = $totalSeconds / $recordCount;

        // Ensure average is positive
        $averageSeconds = max(0, $averageSeconds);

        // Convert average sleep time to hours and minutes
        $averageHours = floor($averageSeconds / 3600);
        $averageMinutes = floor(($averageSeconds % 3600) / 60);

        // Format the average sleep time string
        $averageSleepTimeString = sprintf('%02dHr %02dMin', $averageHours, $averageMinutes);

        return $averageSleepTimeString;
    } else {
        return "00Hr 00Min";
    }

}

?>

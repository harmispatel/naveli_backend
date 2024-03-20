<?php

use Spatie\Permission\Models\Role;
use App\Models\User;
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




?>

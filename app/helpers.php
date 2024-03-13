<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

 function getRoleList(){

       $roles = Role::where('id','!=','1')->get();
       return $roles;
 }

 function uuId(){

    $uuid  = Str::uuid();
    $uniqueNumber = substr($uuid, 0, 15);
    return $uniqueNumber;
 }

?>

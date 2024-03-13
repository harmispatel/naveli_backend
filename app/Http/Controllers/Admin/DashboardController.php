<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard View
    public function index()
    {
        try{
            $users_count = User::count();
            return view('admin.dashboard.dashboard',compact('users_count'));
        }catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
      
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

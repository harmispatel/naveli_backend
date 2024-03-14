<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Show Admin Login Form
    public function showAdminLogin()
    {
        //session(['previousUrl' => url()->previous()]);
        return view('auth.login');
    }

    // Authenticate the Admin User
    public function Adminlogin(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $userstatus = $user ? $user->status : null;

            $input = $request->except('_token');
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($userstatus == 1) {
                if (Auth::attempt($input)) {
                    $username = Auth::user()->name;
                    // Check if there's a previous URL stored in the session

                    // $previousUrl = session()->pull('previousUrl', route('dashboard'));
                    // return redirect()->intended($previousUrl)->with('message', 'Welcome '.$username);
                   
                    return redirect()->route('dashboard')->with('message', 'Welcome '.$username);
                }
            } else {
                return redirect()->route('admin.login')->with('error', 'Your account is deactivated!');
            }

            return back()->with('error', 'Please Enter Valid Email & Password');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

}

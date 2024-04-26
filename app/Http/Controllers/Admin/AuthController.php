<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class AuthController extends Controller
{
    // Show Admin Login Form
    public function showAdminLogin()
    {
        // session(['previousUrl' => url()->previous()]);
        return view('auth.login');
    }

    // Authenticate the Admin User
    public function Adminlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        try {
            $user = User::where('email', $request->email)->first();
            $userstatus = $user ? $user->status : null;
            
            $input = $request->except('_token');
            
                if (Auth::attempt($input)) 
                {
                  if ($userstatus == 1) 
                    {
                        $username = Auth::user()->name;

                            // $otpGenrate = '';
                            // for ($i = 0; $i < 6; $i++) {
                            //     $otpGenrate .= rand(0, 9);
                            // }

                        $otpGenrate = '123456';
    
                        $otp = [
                            'code' => $otpGenrate,
                            'expires_at' => now()->addMinutes(2)->format('Y-m-d H:i:s') // Set expiry time for 2 minutes
                        ];
                        $request->session()->put('otp', $otp);
                        
                        // Send OTP via Laravel Mail
                        // Mail::to($request->email)->send(new UserMail($otp['code']));
                         
                        // Start the countdown timer
                        $request->session()->put('otp_start_time', now()->timestamp);
    
                        return redirect()->route('verify.otp.form')->with('success', 'OTP sent successfully.');
                      
                    } else {
                        return redirect()->route('admin.login')->with('error', 'Your account is deactivated!');
                    }                  
                }
           
                return redirect()->back()->withInput()->with('error', 'Invalid email or password');
            
        } catch (\Throwable $th) { 
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function verifyOTPForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        // Retrieve OTP and its expiry time from session
        $storedOTP = $request->session()->get('otp');
       
        if(isset($storedOTP)){      
            if ($request->otp === $storedOTP['code']) {
                if ( now()->lt($storedOTP['expires_at'])) {

                    $username = Auth::user()->name;
                    $request->session()->forget('otp');
                    $request->session()->put('is_verified',true);
                    return redirect()->route('dashboard')->with('message', 'Welcome ' . $username);

                }else{
                  return redirect()->back()->with('error', 'OTP Expired');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid OTP');
            }
        }else{
            return redirect()->back()->with('error', 'First Enter Your Credentials And Get OTP');
        }
    }
   
    public function resendOTP(Request $request)
    {
        try {
            // Retrieve user email from session or database
            $userEmail = auth()->user()->email; // Change this according to your user authentication logic

            // $otpGenrate = '';
            // for ($i = 0; $i < 6; $i++) {
            //     $otpGenrate .= rand(0, 9);
            // }

            $otpGenrate = '123456';

            $otp = [
                'code' => $otpGenrate,
                'expires_at' => now()->addMinutes(2)->format('Y-m-d H:i:s')
            ];

            $request->session()->put('otp', $otp);
          
           // Send OTP via Laravel Mail
            // Mail::to($userEmail)->send(new UserMail($otp['code']));

             return response()->json(['success' => true, 'message' => 'OTP email sent successfully']);
            
           // return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false]);
        }
    }

    
}

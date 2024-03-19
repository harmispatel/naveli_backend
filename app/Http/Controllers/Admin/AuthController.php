<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;

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
                    $otpGenrate = '';
                    for ($i = 0; $i < 6; $i++) {
                        $otpGenrate .= rand(0, 9); // Append a random digit (0-9) to the OTP string
                    }

                    $otp = [
                        'code' => $otpGenrate,
                        'expires_at' => now()->addMinutes(1) // OTP expires after 1 minute
                    ];

                    // Send OTP via email
                    Mail::send([], [], function ($message) use ($request, $otp) {
                        $message->from('developers@harmistechnology.com');
                        $message->to($request->email);
                        $message->subject('OTP Verification');
                        $message->setBody('Your OTP for verification is: ' . $otp['code']);
                    });

                    $request->session()->put('otp', $otp);

                    // $previousUrl = session()->pull('previousUrl', route('dashboard'));
                    // return redirect()->intended($previousUrl)->with('message', 'Welcome '.$username);
                    return redirect()->route('verify.otp.form')->with('success', 'OTP sent successfully.');
                    // return redirect()->route('dashboard')->with('message', 'Welcome '.$username);
                }
            } else {
                return redirect()->route('admin.login')->with('error', 'Your account is deactivated!');
            }

            return back()->with('error', 'Please Enter Valid Email & Password');
        } catch (\Throwable $th) {
            dd($th);
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

        if ($storedOTP && now()->lt($storedOTP['expires_at'])) {
            // Check if the submitted OTP matches the stored OTP
            if ($request->otp === $storedOTP['code']) {

                $username = Auth::user()->name;
                $request->session()->forget('otp');
                return redirect()->route('dashboard')->with('message', 'OTP Verified. Welcome!' . $username);
            } else {

                return back()->withErrors(['otp' => 'Invalid OTP']);
            }
        } else {

            // $otpGenrate = '';
            // for ($i = 0; $i < 6; $i++) {
            //     $otpGenrate .= rand(0, 9);
            // }
            // $newOTP = [
            //     'code' => $otpGenrate,
            //     'expires_at' => now()->addMinutes(1)
            // ];

            // Mail::send([], [], function ($message) use ($request, $newOTP) {
            //     $message->from('developers@harmistechnology.com');
            //     $message->to($request->email);
            //     $message->subject('OTP Verification');
            //     $message->setBody('Your OTP for verification is: ' . $newOTP['code']);
            // });

            // $request->session()->put('otp', $newOTP['code']);
            return back()->withErrors(['otp' => 'OTP expired!']);
        }
    }

}

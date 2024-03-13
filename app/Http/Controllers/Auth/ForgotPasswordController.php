<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    /**
     * Write code on check User Email Authenticated
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send Mail
        try {
            $mail = Mail::send(
                'auth.bladeEmail',
                ['token' => $token],
                function ($message) use ($request, $token) {
                    $message->from(env("MAIL_FROM_ADDRESS"));
                    $message->to($request->email);
                    $message->subject('Reset Password');
                }
            );

            $usermail = User::where('email', $request->email)->update(['remember_token' => $token]);

            return back()->with('success', 'We have e-mailed your password reset link!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Failed to send an Email');
        }
    }

    public function showresetpasswordform($token)
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    public function submitresetpasswordform(Request $request)
    {
        $updatePassword = DB::table('users')
            ->where([
                'remember_token' => $request->token,
            ])->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        // User Update Password
        $user = User::where('remember_token', $request->token)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['token' => $request->token])->delete();

        return redirect()->route('admin.login')->with('success', 'Your password has been changed!');
    }

    use SendsPasswordResetEmails;
}

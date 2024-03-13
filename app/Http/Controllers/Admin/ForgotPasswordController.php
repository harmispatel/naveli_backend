<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Carbon\Carbon;use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //
    /**
     * Write code on show Forgetpassword Form
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    /**
     * Write code on check User Email Authenticated
     */
    public function submitForgetPasswordForm(PasswordRequest $request)
    {
        $token = Str::random(10);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send Mail
        try {
            Mail::send(
                'auth.email',
                ['token' => $token],
                function ($message) use ($request) {
                    $message->from('developers@harmistechnology.com');
                    $message->to($request->email);
                    $message->subject('Reset Password');
                }
            );
            User::where('email', $request->email)->update(['remember_token' => $token]);
            return back()->with('success', 'We have e-mailed your password reset link!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function showresetpasswordform($token)
    {
        return view('auth.resetPassword', ['token' => $token]);
    }

    public function submitresetpasswordform(PasswordRequest $request)
    {
        try {

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

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

    }
}

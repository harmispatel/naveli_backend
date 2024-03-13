<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\passwordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends BaseController
{
    public function sendOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users',
            ],
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 500);
        }

        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $Data = DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send mail

        try {
            $mail = Mail::send(
                'auth.apiEmail',
                ['token' => $token],
                function ($message) use ($request, $token) {
                    $message->from(env("MAIL_FROM_ADDRESS"));
                    $message->to($request->email);
                    $message->subject('Reset Password');
                }
            );

            $user = User::where('email', $request->email)->update(['remember_token' => $token]);

            $success = [
                'user' => $user,
            ];

            return $this->sendResponse($success, 'Email Sent SuccessFully!', true);
        } catch (\Throwable $th) {
            return $this->sendError('Something Went Wrong!', [], 500);
        }
    }

    public function checkOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'remember_token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $checkOtp = User::where('email', $request->email)
                ->where('remember_token', $request->remember_token)->first();

            if ($checkOtp) {
                $success = [
                    'checkOtp' => $checkOtp,
                ];

                return $this->sendResponse($success, 'Otp verified Successfully!', true);
            } else {
                return $this->sendError('Invalid Otp!', [], 500);
            }
        } catch (\Throwable $th) {
            return $this->sendError('Something Went Wrong!', [], 500);
        }
    }

    public function confirmPassword(passwordRequest $request)
    {
        try {
            $id = Auth::user()->id;

            $user = User::find($id);

            if (!$user) {
                return $this->sendError('User not found', [], 404);
            }

            $user->update([
                'password' => Hash::make($request->new_password),
                'remember_token' => null,
            ]);

            return $this->sendResponse($user, 'Password updated successfully', true);
        } catch (\Throwable $th) {
            return $this->sendError('Something Went Wrong', [], 500);
        }
    }
}

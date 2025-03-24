<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Yoeunes\Toastr\Facades\Toastr;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $verificationCode = rand(100000, 999999);

        try {
            // Create user with verification code
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => $input['password'],
                'verification_code' => $verificationCode,
                'status' => 0,
                'is_registration_by' => null,
            ]);

            // Assign role to the user
            $user->assignRole('User');

            // Send verification email
            Mail::to($request->email)->send(new VerifyMail($user));

            return response()->json([
                'success' => true,
                'message' => 'Account created, please verify your email.',
            ], 201); // 201 Created
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => 'The email has already been taken. Please choose a different email.'
                ], 409); // 409 Conflict
            }
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.'
            ], 500); // 500 Internal Server Error
        }
    }

    public function verify(Request $request)
    {
        // Validate the input
        $this->validate($request, [
            'verification_code' => 'required',
        ]);
        // Find the user by verification code
        $user = User::where('verification_code', $request->verification_code)->first();
        if ($user) {
            // Update the user's status and clear the verification code
            $user->update([
                'status' => 1,
                'verification_code' => null,
            ]);
            // Set the email verified timestamp
            $user->email_verified_at = now();
            $user->save();
            // Return a success response
            return response()->json([
                'message' => 'Your account has been verified. You can now login.',
                'user' => $user, // Optionally return user data if needed
            ], 200);
        } else {
            // Return error response for invalid verification code
            return response()->json([
                'message' => 'Invalid verification code.',
            ], 400);
        }
    }

    public function resendVerificationCode(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->status == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your email is already verified.'
                ], 400);
            }
            $verificationCode = rand(100000, 999999);
            $user->update([
                'verification_code' => $verificationCode
            ]);
            Mail::to($request->email)->send(new VerifyMail($user));
            return response()->json([
                'success' => true,
                'message' => 'Verification code has been resent to your email.'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'User not found with this email.'
        ], 404);
    }


    public function login(Request $request)
    {
        // Validate input
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // // Attempt to authenticate the user
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     $user = Auth::user();

        //     // Check if the email is verified
        //     if (empty($user->email_verified_at)) {
        //         return response()->json([
        //             'message' => 'Please verify your email first.',
        //         ], 401); // 401 Unauthorized
        //     }

            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Could not login. Invalid email or password.',
                ], 401);
            }
            if ($user->email_verified_at === null) {
                return response()->json([
                    'message' => 'Please verify your email first.',
                ], 403);
            }

            // Generate a new token
            $token = $user->createToken('YourAppName')->plainTextToken;

            // Return a success response with the token
            return response()->json([
                'message' => 'Login successful.',
                'token' => $token,
                'user' => $user, // Optionally return user data
            ], 200);

        // }
        // // Return error response for invalid credentials
        // return response()->json([
        //     'message' => 'Invalid email or password.',
        // ], 401); // 401 Unauthorized
    }

    public function forgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found with this email.',
            ], 404);
        }

        $resetCode  = rand(100000, 999999);
        $user->update([
            'reset_password_token' => $resetCode ,
            'reset_password_token_created_at' => now(),
        ]);

        // Send reset password email
        Mail::to($user->email)->send(new ResetPasswordMail($user, $resetCode));

        return response()->json([
            'success' => true,
            'message' => 'Reset code has been sent to your email.',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'resetCode' => 'required',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('reset_password_token', $request->resetCode)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid resetCode or email.',
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_password_token' => null,
            'reset_password_token_created_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully.',
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'new_password_confirmation' => 'required|string|min:6',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 400);
        }

        if ($request->new_password !== $request->new_password_confirmation) {
            return response()->json([
                'success' => false,
                'message' => 'New password and new password confirmation do not match.',
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully.',
        ], 200);
    }


    public function userInfo()
    {
        $user = Auth::user();
        return response()->json([
            'message' => 'User info',
            'user' => $user, // Optionally return user data
        ], 200);
    }

    public function updateInfo(Request $request)
{
    // Validate the input
    $this->validate($request, [
        'name' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:15',
        'email' => 'nullable|email,', // Ignore current user's email
    ]);

    $user = Auth::user();

    // Only update the fields that are present in the request
    $user->update($request->only('name', 'phone', 'email'));

    return response()->json([
        'success' => true,
        'message' => 'User information updated successfully.',
        'user' => $user,
    ], 200);
}


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out',
        ], 200);
    }




}

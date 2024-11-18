<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yoeunes\Toastr\Facades\Toastr;

class UserController extends Controller
{
    public function storeRegistration(Request $request)
    {
        // Validate input
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
                'role' => 'User',
            ]);

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
                'error' => 'Invalid verification code.',
            ], 400);
        }
    }

    public function login(Request $request)
    {
        // Validate input
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Generate a new token
            $token = $user->createToken('YourAppName')->plainTextToken;

            // Return a success response with the token
            return response()->json([
                'message' => 'Login successful.',
                'token' => $token,
                'user' => $user, // Optionally return user data
           
            ], 200);
        } else {
            // Return error response for invalid credentials 
            return response()->json([
                'error' => 'Invalid email or password.',
            ], 401); // 401 Unauthorized
        }
    }

    public function userInfo()
    {
        $user = Auth::user();
            return response()->json([
                'message' => 'User info',
                'user' => $user, // Optionally return user data
            ], 200);
        }
}

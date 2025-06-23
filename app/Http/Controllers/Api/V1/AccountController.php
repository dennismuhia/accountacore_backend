<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AuthMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{

    public function userSignUp(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2',
                'phone_number' => 'required|digits:10|unique:users,phone_number',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                Log::warning('User signup validation failed', ['errors' => $validator->messages()]);
                return response()->json([
                    'code' => 400,
                    'errors' => $validator->messages(),
                ], 400);
            }

            // Generate unique slug & verification token
            $uniqueSlug = Str::random(20);
            $verificationToken = random_int(10000, 99999);

            // Create and save user
            $user = User::create([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'slug' => $uniqueSlug,
                'password' => Hash::make($request->password),
                'two_factor_recovery_codes' => $verificationToken,
                'two_factor_secret' => $verificationToken,
            ]);

            try {
                // Send verification email
                Mail::to($request->email)->send(new AuthMail([
                    'name' => $request->name,
                    'code' => $verificationToken,
                    'message' => 'Here is your verification email',
                ]));

                Log::info('Verification email sent', ['email' => $request->email]);

            } catch (\Exception $e) {
                // Log email sending failure
                Log::error('Failed to send verification email', [
                    'email' => $request->email,
                    'error' => $e->getMessage()
                ]);

                return response()->json([
                    'code' => 500,
                    'message' => 'Account created, but failed to send verification email. Please contact support.',
                ], 500);
            }

            // Return success response
            Log::info('User created successfully', ['user_id' => $user->id]);
            return response()->json([
                'code' => 200,
                'token' => $verificationToken,
                'user' => $user,
                'message' => 'Account created successfully. Please check your email for the code sent to proceed.',
            ]);

        } catch (\Exception $e) {
            // Log general failure
            Log::error('User signup failed', ['error' => $e->getMessage()]);
            return response()->json([
                'code' => 500,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|digits:5',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'code' => 400,
                    'errors' => $validator->messages(),
                ], 400);
            }

            // Find the user by email
            $user = User::where('email', $request->email)->with('county','region','subcounty')->first();

            if (!$user) {
                return response()->json([
                    'code' => 404,
                    'message' => 'User not found',
                ], 404);
            }

            // Check if the OTP matches
            if ($user->two_factor_secret == $request->otp) {
                // Mark user as verified
                $user->email_verified_at = now();
                $user->two_factor_secret = null; // Clear the OTP after successful verification
                $user->save();
                $user->assignRole("user");
                Log::info('User verified successfully', ['user_id' => $user->id]);

                return response()->json([
                    'code' => 200,
                    'token' => $user->createToken('authToken')->plainTextToken,
                    'message' => 'OTP verified successfully. Your account is now active.',
                    'user' => $user,
                ]);
            } else {
                Log::warning('Invalid OTP attempt', ['email' => $request->email]);

                return response()->json([
                    'code' => 400,
                    'message' => 'Invalid OTP. Please try again.',
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('OTP verification failed', ['error' => $e->getMessage()]);

            return response()->json([
                'code' => 500,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }

    public function login(Request $request)
    {

        // Step 1: Validate the request
        $request->validate([
            'identifier' => 'required',
            'password' => 'required|string|min:6',
        ]);

        $identifier = $request->input('identifier');
        $fieldType = filter_var($identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        // Step 2: Check if user exists
        $user = User::where($fieldType, $identifier)->first();

        if (!$user) {
            return response()->json([
                'code' => 404,
                'message' => "Account with this {$fieldType} does not exist."
            ], 404);
        }

        // Step 3: Optional email verification check
        if ($fieldType === 'email' && is_null($user->email_verified_at)) {
            return response()->json([
                'code' => 403,
                'message' => 'Your email is not verified. Please verify before logging in.'
            ], 403);
        }

        // Step 4: Attempt login
        if (Auth::attempt([$fieldType => $identifier, 'password' => $request->password])) {
            $user = Auth::user()->load('county', 'region', 'subcounty');

            return response()->json([
                'code' => 200,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $user->createToken('authToken')->plainTextToken
            ]);
        }

        // Step 5: Invalid credentials
        return response()->json([
            'code' => 401,
            'message' => 'Invalid credentials. Please try again.'
        ], 401);
    }



    public function updateCounty(Request $request)
    {
        try {
            // Step 1: Validate the request
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email',
                'county_id' => 'required|integer|exists:counties,id'
            ]);

            // Step 2: Find the user by email
            $user = User::where('email', $validatedData['email'])->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Step 3: Update the county_id
            $user->county_id = $validatedData['county_id'];
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'County updated successfully',
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the county',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateConstituency(Request $request)
    {
        try {
            // Step 1: Validate the request
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email',
                'constituency_id' => 'required|integer|exists:regions,id'
            ]);

            // Step 2: Find the user by email
            $user = User::where('email', $validatedData['email'])->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Step 3: Update the county_id
            $user->region_id = $validatedData['constituency_id'];
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Constituency updated successfully',
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the county',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updateSubCounty(Request $request)
    {
        try {
            // Step 1: Validate the request
            $validatedData = $request->validate([
                'email' => 'required|email|exists:users,email',
                'subcounty_id' => 'required|integer|exists:regions,id'
            ]);

            // Step 2: Find the user by email
            $user = User::where('email', $validatedData['email'])->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Step 3: Update the county_id
            $user->subcounty_id = $validatedData['subcounty_id'];
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Coonstituency updated successfully',
                'user' => $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the county',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function getUser($id){
        $user=User::where('id',$id)->with('county','region','subcounty')->first();
        return response()->json($user);
    }

    public function addBookmark($userid, $newsId)
    {
        $user = User::find($userid);
        $news = News::find($newsId);

        if (!$user || !$news) {
            return response()->json([
                'bookmarked' => false,
                'message' => 'User or News not found'
            ], 404);
        }

        if ($user->bookmarkedNews()->where('news_id', $newsId)->exists()) {
            $user->bookmarkedNews()->detach($newsId);
            return response()->json(['bookmarked' => false, 'message' => 'Removed from bookmarks']);
        } else {
            $user->bookmarkedNews()->attach($newsId);
            return response()->json(['bookmarked' => true, 'message' => 'Bookmarked successfully']);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function corporatelmemberaccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'phone_number' => 'required|digits:10|unique:users,phone_number',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string'
        ]);
        if ($validator->fails()) {
            $response = [
                'code' => 400,
                'errors' => $validator->messages(),
            ];
            return response()->json($response);
        } else {

            $timenow = time();
            $checknum = "1234567898746351937463790";
            $checkstring = "QWERTYUIOPLKJHGFDSAZXCVBNMmanskqpwolesurte";
            $checktimelength = 6;
            $checksnumlength = 6;
            $checkstringlength = 20;
            $randnum = substr(str_shuffle($timenow), 0, $checktimelength);
            $randstring = substr(str_shuffle($checknum), 0, $checksnumlength);
            $randcheckstring = substr(str_shuffle($checkstring), 0, $checkstringlength);
            $totalstring = str_shuffle($randcheckstring . "" . $randnum . "" . $randstring);
            $timenows = time();
            $checknums = "1234567898746351937463790";
            $checkstrings = "QWERTYUIOPLKJHGFDSAZXCVBNMmanskqpwolesurte191827273jkskalqKNJAHSGETWIOWKSNXJNEUDNEKDKSMKIDNUENDNXKSKEJNEJHCBRFGEWVJHBKWJEBFRNKWJENFECKWLERKJFNRKEHBJWEiwjWSIWMSWISWQOQOAWSAMJENEJEEDEWSSRFRFTHUJOKMNZBXVCX";
            $checktimelengths = 10;
            $checksnumlengths = 5;
            $checkstringlength = 5;
            $randnums = substr(str_shuffle($timenows), 0, $checktimelengths);
            $randstrings = substr(str_shuffle($checknums), 0, $checksnumlengths);
            $randcheckstrings = substr(str_shuffle($checkstrings), 0, $checkstringlength);
            $totalstrings = str_shuffle($randcheckstrings . "" . $randnums . "" . $randstrings);

          
                $token = mt_rand(111111, 999999);
                $user = new User;
                $user->name = $request->first_name;
                $user->phone_number = $request->phone_number;
                $user->email = $request->email;
                $user->slag = $totalstrings;
                $user->password = bcrypt($request->password);
                $user->gender = $request->gender;
                $user->two_factor_recovery_codes = $token;
                $user->two_factor_secret = $token;
                $user->save();
                Mail::to($user->email)->send(new ApiVerifyStaffEmail($user, $token));

                $response = [
                    'code' => 200,
                    'token' => $token,
                    'user' => $user,
                    'message' => 'Account created successfully. Please check your email for the code sent to proceed.',
                ];

                return response()->json($response);
           
        }
    }

}

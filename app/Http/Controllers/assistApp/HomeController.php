<?php

namespace App\Http\Controllers\assistApp;

use App\Http\Controllers\Response;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    

    public function get_profile()
    {
        try {
            $user = User::where('id', auth()->user()->id)->where('status', 1)->where('role', 13)->first();
            if ($user) {
                return Response::suc(array('user' => $user));
            } else {
                return Response::err('No Data');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_home()
    {
        try {
            $user = User::where('id', auth()->user()->id)->where('status', 1)->where('role', 13)->first();
            if ($user) {
                return Response::suc(array('user' => $user));
            } else {
                return Response::err('No Data');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function send_otp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
            
            // $otp = rand(1000, 9999);
           $otp = "0000";
            $phone = $request->input('phone');
            $user = User::where('username', $phone)->where('status', 1)->where('role', 13)->first();
            if (!$user)
                return Response::err('Invalid Credentials');

            $userUpdate = User::where('username', $phone)->where('status', 1)->where('role', 13)->update(['otp' => $otp]);
            if ($userUpdate) {
                $this->send_login_otp($phone, $otp, $user->name);
                return Response::suc('Otp Sent');
            } else {
                return Response::err('Please try again after some time');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function api_logout()
    {
        try {
            $token = JWTAuth::invalidate(JWTAuth::getToken());
            if ($token)
                return Response::suc('Successfully logged out');
            return Response::err('Please try again');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\{
    User
};
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Services\FCMService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function checkRole(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
           
            $phone = $request->input('phone');
            $user = User::select('id','role','org_id')->where('username', $phone)->where('status', 1)->first();
            if (!$user)
                return Response::err('Invalid Credentials');

            if ($user){
                return Response::suc(array('user' => $user));
            } else{
                return Response::err('Please try again after some time');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function sendOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'role' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
            $role = $request->role;
            // $otp = rand(1000, 9999);
           $otp = "0000";
            $phone = $request->input('phone');
            $user = User::where('username', $phone)->where('status', 1)->where('role', $role)->first();
            if (!$user)
                return Response::err('Invalid Credentials');

            $userUpdate = User::where('username', $phone)->where('status', 1)->where('role', $role)->update(['otp' => $otp]);
            if ($userUpdate){
                $this->send_login_otp($phone, $otp, $user->name);
                return Response::suc('Otp Sent');
            } else{
                return Response::err('Please try again after some time');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                'fcm_token' => 'required',
                'role' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $role = $request->input('role');
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', $role)->first();
            if (empty($user))
                return Response::err('Invalid Credentials');

            $token = JWTAuth::fromUser($user);
            User::where('id', $user->id)->update(['fcm_token' => $request->input('fcm_token'), 'otp' => null, 'duty_status' => 1]);
            return Response::suc(array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

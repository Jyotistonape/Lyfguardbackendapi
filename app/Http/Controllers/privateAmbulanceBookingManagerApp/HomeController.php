<?php

namespace App\Http\Controllers\privateAmbulanceBookingManagerApp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceBooking;
use App\Models\PrivateAmbulanceDriverDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    private $ambulance, $driver, $branch, $booking;

    public function __construct()
    {
        $this->ambulance = new PrivateAmbulance();
        $this->driver = new PrivateAmbulanceDriverDetail();
        $this->booking = new PrivateAmbulanceBooking();
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
            $user = User::where('username', $phone)->where('status', 1)->where('role', 11)->first();
            if (!$user)
                return Response::err('Invalid Credentials');

            $userUpdate = User::where('username', $phone)->where('status', 1)->where('role', 11)->update(['otp' => $otp]);
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

    public function get_profile()
    {
        try {
            $user = User::where('id', auth()->user()->id)->where('status', 1)->where('role', 11)->first();
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
            $drivers = $this->driver->getAllDriver();
            $ambulances = $this->ambulance->getApiAllAmbulance();
            $activeBookings = $this->booking->getApiActiveBooking();
            return Response::suc(array('ambulances' => $ambulances, 'drivers' => $drivers, 'activeBookings' => $activeBookings));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function api_logout()
    {
        try {
            User::where('id', auth()->user()->id)->where('role', 11)->update(['duty_status' => 0]);
            $token = JWTAuth::invalidate(JWTAuth::getToken());
            if ($token)
                return Response::suc('Successfully logged out');
            return Response::err('Please try again');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

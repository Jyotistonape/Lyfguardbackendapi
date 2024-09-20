<?php

namespace App\Http\Controllers\privateAmbulanceDriverApp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceDriverDetail;
use App\Models\PrivateAmbulanceBooking;
use App\Models\PrivateAmbulanceAmenity;
use App\Models\PrivateAmbulanceType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    private $driver, $ambulance, $booking, $amenity, $type;

    public function __construct()
    {
        $this->driver = new PrivateAmbulanceDriverDetail();
        $this->ambulance = new PrivateAmbulance();
        $this->ambulanceBooking = new PrivateAmbulanceBooking();
        $this->amenity = new PrivateAmbulanceAmenity();
        $this->type = new PrivateAmbulanceType();
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
            $user = User::where('username', $phone)->where('status', 1)->where('role', 10)->first();
            if (!$user)
                return Response::err('Invalid Credentials');

            $userUpdate = User::where('username', $phone)->where('status', 1)->where('role', 10)->update(['otp' => $otp]);
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

    public function get_home(){
        try {
            $ambulances = $this->ambulance->getApiDriverCurrentAmbulance();
           
            if($ambulances){
                $availableAmenities = $this->amenity->getApiAmenitiesByIds($ambulances->available_amenities);
            } else{
                $availableAmenities = '';
            }
            $driverProfile = $this->driver->getApiDriverProfile();
            $privateBookings =$this->ambulanceBooking->getApiActiveBooking();

            if ($driverProfile)
                return Response::suc(array('ambulances'=>$ambulances, 'availableAmenities' => $availableAmenities, 'activeBookings' => $privateBookings));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_profile()
    {
        try {
            $driver = $this->driver->getApiDriverProfile();
            
            if ($driver) {
                return Response::suc(array('driver' => $driver));
            } else {
                return Response::err('No Data');
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

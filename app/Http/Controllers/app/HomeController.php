<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Response;
use App\Models\Booking;
use App\Models\PrivateAmbulanceBooking;
use App\Models\User;
use App\Models\Branch;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
    private $userDetail, $booking, $privateBooking, $branch;
    public function __construct()
    {
        $this->userDetail = New UserDetail();
        $this->booking = New Booking();
        $this->privateBooking = New PrivateAmbulanceBooking();
        $this->branch = new Branch();
    }

    public function get_home()
    {
        try {
            $userdetails = $this->userDetail->getApiUserDetailsByUserID();
            if ($userdetails) {
                $activeBookings = $this->booking->getApiActiveBooking();
                $privateActiveBookings = $this->privateBooking->getApiActiveBooking();
                if ($userdetails->name != null && $userdetails->email != null && $userdetails->phone != null && $userdetails->gender != null && $userdetails->blood_group != null && $userdetails->dob){
                    return Response::suc(array('userDetails' => $userdetails, 'is_profile_completed' => 1, 'activeBookings' => $activeBookings, 'privateActiveBookings' => $privateActiveBookings, 'url' => asset('storage/')));
                } else{
                    return Response::suc(array('userDetails' => $userdetails, 'is_profile_completed' => 0, 'activeBookings' => $activeBookings, 'privateActiveBookings' => $privateActiveBookings, 'url' => asset('storage/')));
                }
            } else{
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
            $user = User::where('username', $phone)->where('status', 1)->first();
            if ($user){
                if($user->role == 8) {
                    $userUpdate = User::where('username', $phone)->where('status', 1)->where('role', 8)->update(['otp' => $otp]);
                } else{
                    return Response::err('This number is already exists!');
                }
            } else{
                $userUpdate = User::create([
                    'slug' => $this->generateSlug($phone, 'users'),
                    'name' => 'User',
                    'username' => $phone,
                    'role' => 8,
                    'image' => 'user.png',
                    'otp' => $otp,
                    'password' => Hash::make(Str::random(8)),
                ]);
            }
            if ($userUpdate) {
                $this->send_login_otp($phone, $otp, 'User');
                return Response::suc('Otp Sent');
            } else {
                return Response::err('Invalid Credentials');
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

    public function commonGetProfile()
    {
            try {
              $user = User::where('id', auth()->user()->id)->where('status', 1)->where('role', auth()->user()->role)->first();
              if(auth()->user()->role == 5)
              {
                if($user)
                {
                    $branch = $this->branch->getApiBokkingManagerBranchByBranchID($user->org_id);
                    return Response::suc(array('user' => $user, 'managerData' => $branch));
                }
              }
              else
              {
                    if ($user) {
                        return Response::suc(array('user' => $user));
                    }
               }
            } catch (\Exception $e) {
                return Response::err($e->getMessage());
            }
    }
}

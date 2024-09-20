<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\Booking;
use App\Models\PrivateAmbulanceBooking;
use App\Models\Branch;
use App\Models\EmergencyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\FCMService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Models\EmergencyType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomBookingController extends Controller
{
    private $branch, $emergency_request, $booking, $ambulance, $privateBooking, $type;
    public function __construct()
    {
        $this->branch = new Branch();
        $this->ambulance = new Ambulance();
        $this->emergency_request = new EmergencyRequest();
        $this->booking = new Booking();
        $this->privateBooking = New PrivateAmbulanceBooking();
        $this->type = new EmergencyType();
    }

    public function create()
    {
        $data['pageName'] = "Add Booking";
        $data['types'] = $this->type->getAllType();
        return view('panel.booking.create-booking')->with('data', $data);
    }

    public function get_branch(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'name' => 'required',
                'phone' => 'required',
                'emergency_type' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            // $name = $request->input('name');
            $name = ($request->input('name')) ? $request->input('name') : 'User';
            $phone = $request->input('phone');
            $emergencyTypeID = $request->input('emergency_type');
            $lat = $request->input('latitude');
            $long = $request->input('longitude');
            
            $user = User::where('username', $phone)->where('role', 8)->first();
            if (!$user)
                $user = User::create([
                    'slug' => $this->generateSlug($name, 'users'),
                    'name' => $name,
                    'username' => $phone,
                    'role' => 8,
                    'image' => 'user.png',
                    'password' => Hash::make(Str::random(8)),
                ]);

            if($user->status != 1){
                User::where('username', $phone)->update(['status' => 1]);
            }   

            $bookingID = $this->genrate_booking_id('LYF-' . strtoupper(Str::random(20)), 'bookings');
            $booking = Booking::create([
                'booking_id' => $bookingID,
                'user_id' => $user->id,
                'user_latitude' => $lat,
                'user_longitude' => $long,
                'emergency_type_id' => $emergencyTypeID,
            ]);
            if (!$booking)
                return Redirect::back()->with('error', 'Please try again later');

            $branches = $this->branch->getApiBranchByLatLong($emergencyTypeID, $lat, $long);
            if ($branches->isNotEmpty()) {
                $i = 1;
                foreach ($branches as $branch) {
                    EmergencyRequest::create([
                        'booking_id' => $bookingID,
                        'counter' => $i,
                        'branch_id' => $branch->id,
                        'booking_manager_id' => $branch->mangerUserID,
                        'request_time' => date('Y-m-d H:i:s')
                    ]);
                    $i++;
                }
                return $this->getFirstBranch($bookingID, $user->id);
                return Redirect::back()->with('success', 'Booking Created !');
            } else {
                Booking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', $user->id)->update([
                    'status' => 4
                ]);
                return Redirect::back()->with('error', 'No Data Found');
            }
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function getFirstBranch($bookingID, $userID)
    {
        try {
            $emergencyRequested = $this->emergency_request->getFirstBranchByBookingID($bookingID);
            if (!$emergencyRequested)
                return Redirect::back()->with('error', 'Please try again');

            Booking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', $userID)->update([
                'status' => 2
            ]);
            $ambulances = $this->ambulance->getApiAllOnDutyAmbulanceByBranch($emergencyRequested->branch_id);
            return $this->pushNotification($emergencyRequested, $ambulances);

        } catch (\Exception $e) { 
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceBooking;
use App\Models\PrivateAmbulanceEmergencyRequest;
use App\Models\PrivateAmbulanceAmenity;
use App\Models\PrivateAmbulanceType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomPrivateBookingController extends Controller
{
    private $private_ambulance_emergency_request, $booking, $ambulance, $amenity, $type;

    public function __construct()
    {
        $this->ambulance = new PrivateAmbulance();
        $this->private_ambulance_emergency_request = new PrivateAmbulanceEmergencyRequest();
        $this->booking = new PrivateAmbulanceBooking();
        $this->amenity = new PrivateAmbulanceAmenity();
        $this->type = new PrivateAmbulanceType();
    }

    public function create()
    {
        $data['pageName'] = "Add Booking"; 
        $data['amenities'] = $this->amenity->getApiAllAmenities();
        $typesArray = array();
        $types = $this->type->getAllAmbulanceType();
        if($types){
            foreach($types as $type){
                $typesArray[] = array(
                    'id' => $type->id,
                    'name' => $type->name,
                    'amenities' => $this->amenity->getAmenitiesByIds($type->amenities),
                );
            }
        }
        $data['dataTypes'] = $typesArray;
        return view('panel.booking.create-private-booking')->with('data', $data);
    }

    public function get_ambulance_type_by_amenities(Request $request){
        $amenities = $request->input('amenities');
        $types = $this->type->getAmbulanceTypeByAmenities();
        // return $types;
        if ($types) {
            $typesData = $this->checkAmenitiesInArray($request->input('amenities'), $types, 'amenities');
            if(count($typesData) != 0){
                return $typesData;
            }
        }
    }

    public function checkAmenitiesInArray($amenities, $data, $fieldName){
        $arr2 = $amenities;
        $arr1 = '';
        $returnArray = array();
        // dd($data);

        foreach($data as $datad){
            if($datad->$fieldName){
                $arr1 = explode(',', $datad->$fieldName);
                if (empty(array_diff($arr2, $arr1))) {
                    array_push($returnArray, $datad);
                }
            }
        }
        return $returnArray;
    } 

    public function get_ambulance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                // 'name' => 'required',
                'phone' => 'required',
                'source_latitude' => 'required',
                'source_longitude' => 'required',
                'destination_latitude' => 'required',
                'destination_longitude' => 'required',
                'amenities_ids' => 'required',
                'ambulance_type_id' => 'required',
                // 'payment_type' => 'required',
                // 'payment_amount' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $name = ($request->input('name')) ? $request->input('name') : 'User';
            $phone = $request->input('phone');
            
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
            $bookingID = $this->genrate_booking_id('LYF-PVB-' . strtoupper(Str::random(20)), 'private_ambulance_bookings');
            
            $booking = PrivateAmbulanceBooking::create([
                'booking_id' => $bookingID,
                'user_id' => $user->id,
                'user_latitude' => $request->input('source_latitude'),
                'user_longitude' => $request->input('source_longitude'),
                'user_destination_latitude' => $request->input('destination_latitude'),
                'user_destination_longitude' => $request->input('destination_longitude'),
                'ambulance_type_id' => $request->input('ambulance_type_id'),
                'amenities_ids' => implode(',', $request->input('amenities_ids')),
                'payment_type' => 'cash',
                'payment_amount' => 1000,
                // 'payment_type' => $request->input('payment_type'),
                // 'payment_amount' => $request->input('payment_amount'),
                'payment_status' => 0,
            ]);
            if (!$booking) 
                return Redirect::back()->with('error', 'Please try again later');
            
            $ambulances = $this->ambulance->getApiAllOnDutyAmbulanceByLatLogAndType($request->input('ambulance_type_id'), $request->input('source_latitude'), $request->input('source_longitude'));
            if ($ambulances->isNotEmpty()) {

                $ambulancesData = $this->check_amenities_inarray($request->input('amenities_ids'), $ambulances, 'available_amenities');
                if(count($ambulancesData) > 0){
                $i = 1;
                foreach ($ambulancesData as $ambulance) {
                    $bookingManagerID = User::where('status', 1)->where('role', 11)->where('org_id', $ambulance->admin_id)->first();
                    PrivateAmbulanceEmergencyRequest::create([
                        'booking_id' => $bookingID,
                        'counter' => $i,
                        'admin_id' => $ambulance->admin_id,
                        'ambulance_id' => $ambulance->id,
                        'booking_manager_id' => ($bookingManagerID && $bookingManagerID->id) ? $bookingManagerID->id : '',
                        'driver_id' => $ambulance->driver_id,
                        'request_time' => date('Y-m-d H:i:s'),
                        'notify_to' => $ambulance->adminNotifyTo
                    ]);
                    $i++;
                }
                return $this->getFirstAmbulance($bookingID, $user->id);
                return Redirect::back()->with('success', 'Booking Created !');
            } else{
            PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', $user->id)->update([
                'status' => 4
            ]);
            return Redirect::back()->with('error', 'No Data Found');
        }
            } else {
                PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', $user->id)->update([
                    'status' => 4
                ]);
                return Redirect::back()->with('error', 'No Data Found');
               
            }
        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function getFirstAmbulance($bookingID, $userID)
    {
        try {
            $emergencyRequested = $this->private_ambulance_emergency_request->getFirstAmbulanceByBookingID($bookingID);
            if (!$emergencyRequested)
                 return Redirect::back()->with('error', 'Please try again');

            PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', $userID)->update([
                'status' => 2
            ]);
            $ambulance = $this->ambulance->getApiAllOnDutyAmbulanceByID($emergencyRequested->ambulance_id);
            // if($sendNotification!=='false'){
               
                if($emergencyRequested->notify_to == 2){
                    return $this->pushNotificationforPrivateAmbulance($emergencyRequested, $ambulance, 'booking_manager_id');
                } else{
                    return $this->pushNotificationforPrivateAmbulance($emergencyRequested, $ambulance, 'driver_id');
                }
            

        } catch (\Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
}

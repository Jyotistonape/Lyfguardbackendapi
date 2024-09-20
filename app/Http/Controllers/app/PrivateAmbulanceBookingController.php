<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceBooking;
use App\Models\PrivateAmbulanceEmergencyRequest;
use App\Models\PrivateAmbulanceAmenity;
use App\Models\PrivateAmbulanceType;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PrivateAmbulanceBookingController extends Controller
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



    public function get_amenity()
    {
        try {
            $amenities = $this->amenity->getApiAllAmenities();
            
            if ($amenities) {
                return Response::suc(array('amenities' => $amenities));
            } else {
                return Response::err('No Data');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_ambulance_type_by_amenity(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amenities' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
            $types = $this->type->getApiAmbulanceTypeByAmenities();
            
            if ($types) {
                $typesData = $this->check_amenities_inarray($request->input('amenities'), $types, 'amenities');
                
                if(count($typesData) != 0){
                    return Response::suc(array('types' => $typesData));
                }
                return Response::err('No Data');
            } else {
                return Response::err('No Data');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_bookings($day)
    {
        try {
            $bookings = $this->booking->getApiAllBooking($day);
            if ($bookings->isNotEmpty())
                return Response::suc(array('bookings' => $bookings));
            return Response::err('No Data');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_booking_by_id($bookingID)
    {
        try {
            $bookingArray = array();
            $booking = $this->booking->getApiBookingByID($bookingID);
            if ($booking){
                $amenities = $this->amenity->getApiAmenitiesByIds($booking->amenities_ids);
                return Response::suc(array('booking' => $booking, 'amenities' => $amenities));
            }
            return Response::err('No Data');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function cancel_booking(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'reason' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $bookingID = $request->input('booking_id');
            $booking = $this->booking->getApiBookingByBookingID($bookingID);
            if (!$booking)
                return Response::err('Invalid Data');

            if($booking->status < 3) {   
            $bookingUpdate = PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('user_id', auth()->user()->id)->update([
                'status' => 6,
                'driver_status' => 5,
                'cancel_by' => 'User',
                'cancel_by_id' => auth()->user()->id,
            ]);
            if ($bookingUpdate) {
                if ($booking->status == 3) {
                    PrivateAmbulance::where('id', $booking->ambulance_id)->update(['running_status' => 1]);
                }

                $this->pushNotificationtoDriver($this->booking->getApiBookingByIDForNotification($bookingID, 6), 'Ride Cancelled !');
                return Response::suc('Booking Cancelled !');
            } else {
                return Response::err('Please try again later');
            }
        }else{
            return Response::err('Ongoing Booking cannot be cancelled.');
        }


        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_booking_update($bookingID)
    {
        try {
            $booking = $this->booking->getBookingByBookingIDAndUser($bookingID);
            if ($booking)
                return Response::suc(array('booking' => $booking));
            return Response::err('No Data');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function get_ambulance(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'source_latitude' => 'required',
                'source_longitude' => 'required',
                'destination_latitude' => 'required',
                'destination_longitude' => 'required',
                'amenities_ids' => 'required',
                'ambulance_type_id' => 'required',
                'payment_type' => 'required',
                'payment_amount' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
            $bookingID = $this->genrate_booking_id('LYF-PVB-' . strtoupper(Str::random(20)), 'private_ambulance_bookings');
            
            $booking = PrivateAmbulanceBooking::create([
                'booking_id' => $bookingID,
                'user_id' => auth()->user()->id,
                'user_latitude' => $request->input('source_latitude'),
                'user_longitude' => $request->input('source_longitude'),
                'user_destination_latitude' => $request->input('destination_latitude'),
                'user_destination_longitude' => $request->input('destination_longitude'),
                'ambulance_type_id' => $request->input('ambulance_type_id'),
                'payment_type' => $request->input('payment_type'),
                'amenities_ids' => $request->input('amenities_ids'),
                'payment_amount' => $request->input('payment_amount'),
                'payment_status' => 0,
            ]);
            // $sendNotification=true;
            // $send_notification=$request->input('send_notification');
            // if(isset($send_notification)){
            //     $sendNotification=$request->input('send_notification');
            // } 
            if (!$booking) 
                return Response::err('Please try again later');
            
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
                return $this->getFirstAmbulance($bookingID);
            } else{
            PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', auth()->user()->id)->update([
                'status' => 4
            ]);
            return Response::err('No Data Found');
        }
            } else {
                PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', auth()->user()->id)->update([
                    'status' => 4
                ]);
                return Response::err('No Data Found');
               
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function getFirstAmbulance($bookingID)
    {
        try {
            $emergencyRequested = $this->private_ambulance_emergency_request->getFirstAmbulanceByBookingID($bookingID);
            if (!$emergencyRequested)
                 Response::err('Please try again');

            PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', auth()->user()->id)->update([
                'status' => 2
            ]);
            $ambulance = $this->ambulance->getApiAllOnDutyAmbulanceByID($emergencyRequested->ambulance_id);
            // if($sendNotification!=='false'){
               
                if($emergencyRequested->notify_to == 2){
                    return $this->pushNotificationforPrivateAmbulance($emergencyRequested, $ambulance, 'booking_manager_id');
                } else{
                    return $this->pushNotificationforPrivateAmbulance($emergencyRequested, $ambulance, 'driver_id');
                }
            // }else{
            //     $data = array('booking' => $emergencyRequested, 'ambulance' => $ambulance);
            //     return $data;
            // }
            

        } catch (\Exception $e) {
            Response::err($e->getMessage());
        }
    }


    public function update_payment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'payment_reference' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $bookingID = $request->input('booking_id');
            $booking = $this->booking->getApiBookingByBookingID($bookingID);
            if (!$booking)
                return Response::err('Invalid Data');

            $bookingUpdate = PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('user_id', auth()->user()->id)->update([
                'payment_status' => 1,
                'payment_date' => date('Y-m-d'),
                'payment_time' => date('H:i:s'),
                'payment_reference' => $request->input('payment_reference'),
            ]);
            if ($bookingUpdate)
                return Response::suc('Payment Updated !');
            return Response::err('Please try again later');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

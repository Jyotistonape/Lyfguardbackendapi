<?php

namespace App\Http\Controllers\privateAmbulanceDriverApp;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceBooking;
use App\Models\PrivateAmbulanceEmergencyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class EmergencyBookingController extends Controller
{

    private $private_ambulance_emergency_request, $booking, $ambulance;

    public function __construct()
    {
        $this->ambulance = new PrivateAmbulance();
        $this->private_ambulance_emergency_request = new PrivateAmbulanceEmergencyRequest();
        $this->booking = new PrivateAmbulanceBooking();
    }

    public function accept_booking_request(Request $request)
    { 
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'ambulance_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');
            $bookingData = $this->booking->getApiBookingByIDForCheck($bookingID);
            if (!$bookingData)
                return Response::err('Invalid Booking Data');
                
            if($bookingData->status == 6){
                return Response::err('Booking Cancelled by '.$bookingData->cancel_by);
            }   

            $driverOtp = rand(1000, 9999);
            $userOtp = rand(1000, 9999);

            $booking = PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('status', 2)->update([
                'status' => 3,
                'driver_id' => auth()->user()->id,
                'ambulance_id' => $request->input('ambulance_id'),
                'driver_otp' => $driverOtp,
                'user_otp' => $userOtp,
                'driver_status' => 1,
                // 'respond_time' => $this->get_time($bookingData->created_at, date('Y-m-d H:i:s'))
            ]);
            if (!$booking)
                return Response::err('Please try again later');

            PrivateAmbulance::where('id', $request->input('ambulance_id'))->where('driver_id', auth()->user()->id)->where('running_status', 1)
                ->update(['running_status' => 2]);

            PrivateAmbulanceEmergencyRequest::where('driver_id', auth()->user()->id)
                ->where('status', 1)->where('booking_id', $bookingID)->update([
                    'action_time' => date('Y-m-d H:i:s'),
                    'status' => 2
                ]);

            $title = "You have a assign a booking, Click here to check.";
            $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 3), 'Ride Approved');

            return Response::suc('Booking Accepted!');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function update_booking_request(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'status' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');
            $bookingData = $this->booking->getApiBookingByIDForCheck($bookingID);
            if (!$bookingData)
                return Response::err('Invalid Booking Data');
                
            if($bookingData->status == 6){
                return Response::err('Booking Cancelled by'.$bookingData->cancel_by);
            }

            $requestResult = PrivateAmbulanceEmergencyRequest::where('driver_id', auth()->user()->id)
                ->where('booking_id', $bookingID)->update([
                    'action_time' => date('Y-m-d H:i:s'),
                    'status' => $request->input('status'),
                ]);
            if ($requestResult) {
                return $this->getAnotherAmbulance($bookingID);
            } else {
                return Response::err('Please try again');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function getAnotherAmbulance($bookingID)
    {
        try {
            $emergencyRequested = $this->private_ambulance_emergency_request->getAmbulanceByBookingIDAndDriver($bookingID, auth()->user()->id);

            if (!$emergencyRequested) {
                PrivateAmbulanceBooking::where('booking_id', $bookingID)->update([
                    'status' => 4
                ]);
                return Response::err('Booking Failed!');
            } else {
                $ambulance = $this->ambulance->getApiAllOnDutyAmbulanceByID($emergencyRequested->ambulance_id);

                if($emergencyRequested->notify_to == 2){
                    return $this->pushNotificationforPrivateAmbulance($emergencyRequested, $ambulance, 'booking_manager_id');
                } else{
                    return $this->pushNotificationforPrivateAmbulance($emergencyRequested, $ambulance, 'driver_id');
                }
            }

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


            $bookingUpdate = PrivateAmbulanceBooking::where('booking_id', $bookingID)->update([
                'status' => 6,
                'driver_status' => 5,
                'cancel_reason' => $request->input('reason'),
                'cancel_by' => 'Driver',
                'cancel_by_id' => auth()->user()->id,
            ]);
            if ($bookingUpdate) {
                if ($booking->status == 3) {
                    PrivateAmbulance::where('id', $booking->ambulance_id)->update(['running_status' => 1]);
                }
                $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 6), 'Ride Cancelled !');
                return Response::suc('Booking Cancelled !');
            } else {
                return Response::err('Please try again later');
            }


        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\bookingManagerApp;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\Booking;
use App\Models\Branch;
use App\Models\EmergencyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class EmergencyBookingController extends Controller
{
    private $branch, $emergency_request, $booking, $ambulance;

    public function __construct()
    {
        $this->branch = new Branch();
        $this->ambulance = new Ambulance();
        $this->emergency_request = new EmergencyRequest();
        $this->booking = new Booking();
    }

    public function get_active_drivers()
    {
        try {
            $ambulances = $this->ambulance->getApiAllOnDutyAmbulanceByBranch(auth()->user()->org_id);
            if ($ambulances->isNotEmpty())
                return Response::suc(array('ambulances' => $ambulances));
            return Response::err('No Data');

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
            $booking = $this->booking->getApiBookingByID($bookingID);
            if ($booking)
                return Response::suc(array('booking' => $booking));
            return Response::err('No Data');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function accept_booking_request(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                // 'ambulance_id' => 'required',
                // 'driver_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');
            $bookingData = $this->booking->getApiBookingByIDForCheck($bookingID);
            if (!$bookingData)
                return Response::err('Invalid Booking Data');
                
            if($bookingData->status == 8){
                return Response::err('Booking Cancelled by '.$bookingData->cancel_by);
            }   

            $bookingManagerOtp = rand(1000, 9999);
            $userOtp = rand(1000, 9999);

            $booking = Booking::where('booking_id', $bookingID)->update([
                'status' => 3, 
                'branch_id' => auth()->user()->org_id,
                'booking_manager_id' => auth()->user()->id,
                // 'ambulance_id' => $request->input('ambulance_id'),
                // 'driver_id' => $request->input('driver_id'),
                'booking_manager_otp' => $bookingManagerOtp,
                'user_otp' => $userOtp,
                // 'driver_status' => 1,
                // 'respond_time' => $this->get_time($bookingData->created_at, date('Y-m-d H:i:s'))
            ]);
            if (!$booking)
                return Response::err('Please try again later');

            // Ambulance::where('id', $request->input('ambulance_id'))->where('running_status', 1)
            //     ->where('branch_id', auth()->user()->org_id)->update(['running_status' => 2]);

            // EmergencyRequest::where('booking_manager_id', auth()->user()->id)
            //     ->where('branch_id', auth()->user()->org_id)->where('status', 1)->where('booking_id', $bookingID)->update([
            //         'action_time' => date('Y-m-d H:i:s'),
            //         'status' => 2
            //     ]);

            $title = "You booking accepted, Click here to check.";
            // $this->pushNotificationtoDriver($this->booking->getApiBookingByIDForNotification($bookingID, 3), $title);
            $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 3), 'Ride Accepted');

            return Response::suc(array('data'=> $booking), 'Booking Accepted!');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function assign_booking_request(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'ambulance_id' => 'required',
                'driver_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');
            $bookingData = $this->booking->getApiBookingByIDForCheck($bookingID);
            if (!$bookingData)
                return Response::err('Invalid Booking Data');
                
            if($bookingData->status == 8){
                return Response::err('Booking Cancelled by '.$bookingData->cancel_by);
            }   

            // $bookingManagerOtp = rand(1000, 9999);
            // $userOtp = rand(1000, 9999);

            $booking = Booking::where('booking_id', $bookingID)->update([
                'status' => 4, 
                'branch_id' => auth()->user()->org_id,
                'booking_manager_id' => auth()->user()->id,
                'ambulance_id' => $request->input('ambulance_id'),
                'driver_id' => $request->input('driver_id'),
                // 'booking_manager_otp' => $bookingManagerOtp,
                // 'user_otp' => $userOtp,
                'driver_status' => 1,
                // 'respond_time' => $this->get_time($bookingData->created_at, date('Y-m-d H:i:s'))
            ]);
            if (!$booking)
                return Response::err('Please try again later');

            Ambulance::where('id', $request->input('ambulance_id'))->where('running_status', 1)
                ->where('branch_id', auth()->user()->org_id)->update(['running_status' => 2]);

            EmergencyRequest::where('booking_manager_id', auth()->user()->id)
                ->where('branch_id', auth()->user()->org_id)->where('status', 1)->where('booking_id', $bookingID)->update([
                    'action_time' => date('Y-m-d H:i:s'),
                    'status' => 2
                ]);

            $title = "You have a assign a booking, Click here to check.";
            $this->pushNotificationtoDriver($this->booking->getApiBookingByIDForNotification($bookingID, 4), $title);
            $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 4), 'Ride Assigned');

            return Response::suc(array('data'=> $booking),'Booking Assigned!');

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
                
            if($bookingData->status == 9){
                return Response::err('Booking Cancelled by User');
            }
            if($bookingData->status == 10){
                return Response::err('Booking Cancelled by Booking Manager');
            }

            $requestResult = EmergencyRequest::where('booking_manager_id', auth()->user()->id)
                ->where('branch_id', auth()->user()->org_id)->where('status', 1)->where('booking_id', $bookingID)->update([
                    'action_time' => date('Y-m-d H:i:s'),
                    'status' => $request->input('status'),
                ]);
            if ($requestResult) {
                return $this->getAnotherBranch($bookingID);
            } else {
                return Response::err('Please try again');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function getAnotherBranch($bookingID)
    {
        try {
            $emergencyRequested = $this->emergency_request->getBranchByBookingIDAndBranch($bookingID, auth()->user()->org_id);

            if (!$emergencyRequested) {
                Booking::where('booking_id', $bookingID)->update([
                    'status' => 8
                ]);
                return Response::err('Booking Failed!');
            } else {
                $ambulances = $this->ambulance->getApiAllOnDutyAmbulanceByBranch($emergencyRequested->branch_id);
                return $this->pushNotification($emergencyRequested, $ambulances);
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


            $bookingUpdate = Booking::where('booking_id', $bookingID)->where('branch_id', auth()->user()->org_id)->update([
                'status' => 10,
                'driver_status' => 5,
                'cancel_by' => 'Booking Manger',
                'cancel_by_id' => auth()->user()->id,
            ]);
            if ($bookingUpdate) {
                // if ($booking->status == 4) {
                    Ambulance::where('id', $booking->ambulance_id)->update(['running_status' => 1]);
                // }

                $this->pushNotificationtoDriver($this->booking->getApiBookingByIDForNotification($bookingID, 10), 'Ride Cancelled !');
                $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 10), 'Ride Cancelled !');
                return Response::suc('Booking Cancelled !');
            } else {
                return Response::err('Please try again later');
            }


        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

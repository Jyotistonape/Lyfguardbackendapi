<?php

namespace App\Http\Controllers\driverApp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\Ambulance;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    private $booking;

    public function __construct()
    {
        $this->booking = new Booking();
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

    public function update_trip(Request $request)
    {
        try { 
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'driver_status' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');

            $booking = $this->booking->getApiBookingByID($bookingID);
            if (!$booking)
                return Response::err('Invalid data');

            $driverStatus = $request->input('driver_status');

            if ($driverStatus == 7) {
                $tripOtp = $request->input('trip_otp');
                if(!$tripOtp)
                   return Response::err('Otp Required!');
                $trip = Booking::where('driver_id', auth()->user()->id)->where('booking_id', $bookingID)->where('booking_manager_otp', $tripOtp)->update([
                    'driver_status' => 4,
                    'status' => 7,
                ]);

                if ($trip) {

                    Ambulance::where('id', $booking->ambulance_id)->where('branch_id', auth()->user()->org_id)
                        ->where('running_status', 2)->where('driver_id', auth()->user()->id)->update([
                            'running_status' => 1,
                        ]);

                    $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 7), 'Ride Completed !');
                    $this->pushNotificationtoBookingManager($this->booking->getApiBookingByIDForNotification($bookingID, 7), 'Ride Completed !');
                    return Response::suc('Trip Status Updated!');
                } else {
                    return Response::err('Invalid Otp!');
                }

            } else {
                $trip = Booking::where('driver_id', auth()->user()->id)->where('booking_id', $bookingID)->update([
                    'driver_status' => $driverStatus,
                    'status' => $driverStatus,
                ]);

                if ($trip) {
                    $this->pushNotificationtoUser($this->booking->getApiBookingByIDAndDriverStatusForNotification($bookingID, $driverStatus), 'Status Change by Driver');
                    $this->pushNotificationtoBookingManager($this->booking->getApiBookingByIDAndDriverStatusForNotification($bookingID, $driverStatus), 'Status Change by Driver');
                    return Response::suc('Trip Status Updated!');
                }  else {
                    return Response::err('Please try again');
                }
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function save_route_coordinates(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');

            $booking = $this->booking->getApiBookingByID($bookingID);
            if ($booking) {
                $latitude = $request->input('latitude');
                $longitude = $request->input('longitude');

                if ($booking->route_array) {
                    $metaDataArray = json_decode($booking->route_array, TRUE);
                    $metaDataArray[] = ['latitude' => $latitude, 'longitude' => $longitude];
                } else {
                    $metaDataArray[] = ['latitude' => $latitude, 'longitude' => $longitude];
                }

                $routeData =  json_encode($metaDataArray, true);

                $bookingUpdate = Booking::where('driver_id', auth()->user()->id)->where('booking_id', $bookingID)->update([
                    'route_array' => $routeData,
                ]);
                if ($bookingUpdate)
                    return Response::suc('Booking Route Coordinates Saved');
                return Response::suc('Please try again');
            } else {
                return Response::err('Something went wrong, Please ry again');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

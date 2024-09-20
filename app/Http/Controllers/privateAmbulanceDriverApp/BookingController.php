<?php

namespace App\Http\Controllers\privateAmbulanceDriverApp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    private $booking;

    public function __construct()
    {
        $this->booking = new PrivateAmbulanceBooking();
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

            if ($driverStatus == 4) {
                $availableAmenities = $request->input('available_amenities');
                $tripOtp = $request->input('trip_otp');
                if(!$availableAmenities || (!$tripOtp))
                    return Response::err('The available_amenities and trip_otp field is required');

                $trip = PrivateAmbulanceBooking::where('driver_id', auth()->user()->id)->where('booking_id', $bookingID)->where('driver_otp', $tripOtp)->update([
                    'driver_status' => 4,
                    'status' => 5,
                ]);

                if ($trip) {

                    PrivateAmbulance::where('id', $booking->ambulance_id)
                        ->where('running_status', 2)->where('driver_id', auth()->user()->id)->update([
                            'running_status' => 1, 
                            'available_amenities' => $availableAmenities
                        ]);

                    $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, 5), 'Ride Completed !');
                    return Response::suc('Trip Status Updated!');
                } else {
                    return Response::err('Please try again');
                }

            } else {
                $trip = PrivateAmbulanceBooking::where('driver_id', auth()->user()->id)->where('booking_id', $bookingID)->update([
                    'driver_status' => $driverStatus,
                ]);

                if ($trip) {
                    $this->pushNotificationtoUser($this->booking->getApiBookingByIDForNotification($bookingID, $driverStatus), 'Status Change by Driver');
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

                $bookingUpdate = PrivateAmbulanceBooking::where('driver_id', auth()->user()->id)->where('booking_id', $bookingID)->update([
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

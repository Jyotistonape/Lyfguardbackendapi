<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\Booking;
use App\Models\PrivateAmbulanceBooking;
use App\Models\Branch;
use App\Models\EmergencyRequest;
use App\Models\User;
use App\Models\DriverDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use App\Services\FCMService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use DB;

class BookingController extends Controller
{
    private $branch, $emergency_request, $booking, $ambulance, $privateBooking,$driver_detial;

    public function __construct()
    {
        $this->branch = new Branch();
        $this->ambulance = new Ambulance();
        $this->emergency_request = new EmergencyRequest();
        $this->booking = new Booking();
        $this->privateBooking = new PrivateAmbulanceBooking();
        $this->driver_detial = new DriverDetail();
    }

    public function get_bookings($day)
    {
        try {
            $privateBookings = $this->privateBooking->getApiAllBooking($day);
            $bookings = $this->booking->getApiAllBooking($day);
            if ($bookings->isNotEmpty())
                return Response::suc(array('bookings' => $bookings, 'privateBookings' => $privateBookings));
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
            return Response::suc('No Data');

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


            $bookingUpdate = Booking::where('booking_id', $bookingID)->where('user_id', auth()->user()->id)->update([
                'status' => 9,
                'driver_status' => 5,
                'cancel_by' => 'User',
                'cancel_by_id' => auth()->user()->id,
            ]);
            if ($bookingUpdate) {
                // if ($booking->status == 9) {
                    Ambulance::where('id', $booking->ambulance_id)->update(['running_status' => 1]);
                // }

                $this->pushNotificationtoDriver($this->booking->getApiBookingByIDForNotification($bookingID, 9), 'Ride Cancelled !');
                $this->pushNotificationtoBookingManager($this->booking->getApiBookingByIDForNotification($bookingID, 9), 'Ride Cancelled !');
                return Response::suc('Booking Cancelled !');
            } else {
                return Response::err('Please try again later');
            }


        } catch (\Exception $e) {
            return Response::err($e->getMessage());
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

//    public function get_branch($emergencyTypeID, $lat, $long, $branchID = null)
    public function get_branch(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'emergency_type_id' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $emergencyTypeID = $request->input('emergency_type_id');
            $lat = $request->input('latitude');
            $long = $request->input('longitude');
            $branchID = $request->input('branch_id');
//            if (!empty($emergencyTypeID) && !empty($lat) && !empty($long)) {
            $bookingID = $this->genrate_booking_id('LYF-' . strtoupper(Str::random(20)), 'bookings');
            $booking = Booking::create([
                'booking_id' => $bookingID,
                'user_id' => auth()->user()->id,
                'user_latitude' => $lat,
                'user_longitude' => $long,
                'emergency_type_id' => $emergencyTypeID,
            ]);
            if (!$booking)
                return Response::err('Please try again later');

            if ($branchID) {
                $branch = $this->branch->getApiBranchByBranchID($branchID);
                if ($branch) {
                    EmergencyRequest::create([
                        'booking_id' => $bookingID,
                        'counter' => 1,
                        'branch_id' => $branch->id,
                        'booking_manager_id' => $branch->mangerUserID,
                        'request_time' => date('Y-m-d H:i:s')
                    ]);
                    return $this->getFirstBranch($bookingID);
                } else {
                    Booking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', auth()->user()->id)->update([
                        'status' => 8
                    ]);
                    return Response::suc('No Data Found');
                }
            } else {
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
//                    return Response::suc(array('branches' => $branches));
                    return $this->getFirstBranch($bookingID);
                } else {
                    Booking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', auth()->user()->id)->update([
                        'status' => 8
                    ]);
                    return Response::suc('No Data Found');
                }
            }
//            }
//            return Response::err('Required field empty');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function getFirstBranch($bookingID)
    {
        try {
            $emergencyRequested = $this->emergency_request->getFirstBranchByBookingID($bookingID);
            if (!$emergencyRequested)
                return Response::err('Please try again');

            Booking::where('booking_id', $bookingID)->where('status', 1)->where('user_id', auth()->user()->id)->update([
                'status' => 2
            ]);
            $ambulances = $this->ambulance->getApiAllOnDutyAmbulanceByBranch($emergencyRequested->branch_id);
            return $this->pushNotification($emergencyRequested, $ambulances);

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

//    public function getAmbulancesByBranchID($emergencyRequested)
//    {
//        try {
//            return $this->ambulance->getApiAllOnDutyAmbulanceByBranch($emergencyRequested->branch_id);
//        } catch (\Exception $e) {
//            return Response::err($e->getMessage());
//        }
//    }

    public function getBookings()
    {
        try {

            $booking = DB::table('bookings as b')
            ->join('branches as bs', 'bs.id', '=', 'b.branch_id')
            ->join('hospitals as h', 'h.id', '=', 'bs.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'bs.type_id')
            // ->join('ambulances as a', 'a.id', '=', 'b.ambulance_id')
            // ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                    ->where('d.role', 6);
            })
            ->leftJoin('ambulances as a', function ($join) {
                $join->on('a.id', '=', 'b.ambulance_id');
            })
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'bs.name as branchName', 'h.name as hospitalName', 'bt.name as branchTypeName', 'bs.latitude as branchLatitude', 'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            // ->where('d.role', 6)
            ->where('u.role', 8);
            if (auth()->user()->role == 8) {
                $booking->where('b.user_id', auth()->user()->id);
            } elseif (auth()->user()->role == 6) {
                $booking->where('b.driver_id', auth()->user()->id);
            } else {
                $booking->where('b.branch_id', auth()->user()->org_id);
            }
            $booking = $booking->get();
            //dd($booking);
            if ($booking->isNotEmpty())
                return Response::suc(array('bookings' => $booking));
            return Response::err('No Data');
           
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function getBookingByBookingID($id)
    {
        try {
            $booking = $this->booking->getApiBookingByID($id);
            if ($booking)
                return Response::suc(array('booking' => $booking));
            return Response::err('No Data');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function acceptBookingRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'booking_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $bookingID = $request->input('booking_id');
            //dd($bookingID);
            $bookingData = $this->booking->getApiBookingByIDForCheck($bookingID);
            //dd($bookingData);
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

    public function assignBookingRequest(Request $request)
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

    public function updateBookingRequest(Request $request)
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

            $reques_query = 
            $reques_query = EmergencyRequest::where('booking_manager_id', auth()->user()->id)
                ->where('branch_id', auth()->user()->org_id)->where('status', 1)->where('booking_id', $bookingID)->latest()->first();


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
            $emergencyRequested = $this->emergency_request->getBranchByBookingIDAndBranchNewFunction($bookingID, auth()->user()->org_id);


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

    public function cancelBooking(Request $request)
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

    public function logout()
    {
        try {
            User::where('id', auth()->user()->id)->where('role', 5)->update(['duty_status' => 0]);
            $token = JWTAuth::invalidate(JWTAuth::getToken());
            if ($token)
                return Response::suc('Successfully logged out');
            return Response::err('Please try again');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function getHomeDashboard()
    {
        try {
            $drivers = $this->driver_detial->getAllDriver();
            $ambulances = $this->ambulance->getApiAllAmbulance();
            $activeBookings = $this->booking->getApiActiveBooking();
            return Response::suc(array('ambulances' => $ambulances, 'drivers' => $drivers, 'activeBookings' => $activeBookings));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function cancel_booking_user(Request $request)
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
            //$booking = $this->booking->getApiBookingByBookingID($bookingID);
            $booking = DB::table('private_ambulance_bookings')
            ->where('booking_id', $bookingID)->latest()->first();
            if (!$booking)
                return Response::err('Invalid Data');


            $bookingUpdate = PrivateAmbulanceBooking::where('booking_id', $bookingID)->where('user_id', auth()->user()->id)->update([
                'status' => 9,
                'driver_status' => 5,
                'cancel_by' => 'User',
                'cancel_by_id' => auth()->user()->id,
            ]);
            if ($bookingUpdate) {
                // if ($booking->status == 9) {
                    //Ambulance::where('id', $booking->ambulance_id)->update(['running_status' => 1]);
                // }

                $this->pushNotificationtoDriver($this->booking->getApiBookingByIDForNotification($bookingID, 9), 'Ride Cancelled !');
                $this->pushNotificationtoBookingManager($this->booking->getApiBookingByIDForNotification($bookingID, 9), 'Ride Cancelled !');
                return Response::suc('Booking Cancelled !');
            } else {
                return Response::err('Please try again later');
            }


        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\privateAmbulanceDriverApp;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulance;
use App\Models\PrivateAmbulanceDriver;
use App\Models\PrivateAmbulanceAmenity;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use Illuminate\Support\Facades\Validator;

class AmbulanceController extends Controller
{
    private $ambulance, $ambulance_driver, $amenity;

    public function __construct()
    {
        $this->ambulance = new PrivateAmbulance();
        $this->ambulance_driver = new PrivateAmbulanceDriver();
        $this->amenity = new PrivateAmbulanceAmenity();
    }


    public function get_ambulance_amenities($ambulanceID)
    {
        try {
            $ambulance = $this->ambulance->getApiAmbulanceByAmbulanceID($ambulanceID);

            if($ambulance){

                $amenities = $this->amenity->getApiAmenitiesByIds($ambulance->amenities);
                if ($amenities)
                    return Response::suc(array('amenities' => $amenities));
                return Response::err('No Data');
            } else{
                return Response::err('Invalid Ambulance');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function postGetAmbulanceAmenityByID(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ambulance_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
            $ambulanceID = $request->ambulance_id;
            $ambulance = $this->ambulance->getApiAmbulanceByAmbulanceID($ambulanceID);

            if($ambulance){

                $amenities = $this->amenity->getApiAmenitiesByIds($ambulance->amenities);
                if ($amenities)
                    return Response::suc(array('amenities' => $amenities));
                return Response::err('No Data');
            } else{
                return Response::err('Invalid Ambulance');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    

    public function get_off_duty_ambulance()
    {
        try {
            $ambulances = $this->ambulance->getDriverApiAllAmbulance();
            if ($ambulances->isNotEmpty())
                return Response::suc(array('ambulances' => $ambulances, 'url' => asset('storage/')));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function start_duty(Request $request)
    {

        try { 
            $validator = Validator::make($request->all(), [
                'ambulance_id' => 'required',
                'available_amenities' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $driverStatus = $this->ambulance->getApiDriverCurrentAmbulance();
            //dd($driverStatus);
            if ($driverStatus){
                return Response::err('Already on duty');
            }

            $ambulanceData = $this->ambulance->getApiAmbulanceByID($request->input('ambulance_id'), 0);
            if(!$ambulanceData)
                return Response::err('Invalid ID');

            $ambulance = PrivateAmbulance::where('id', $request->input('ambulance_id'))->where('status', 1)->where('running_status', 0)->update([
                'driver_id' => auth()->user()->id,
                'running_status' => 1,
                'available_amenities' => $request->input('available_amenities')
            ]);
            if (!$ambulance)
                return Response::err('Something went wrong, Please try again after some time');

            $ambulanceDriver = PrivateAmbulanceDriver::create([
                'ambulance_id' => $request->input('ambulance_id'),
                'admin_id' => auth()->user()->org_id,
                'driver_id' => auth()->user()->id,
                'logged_in_time' => date('Y-m-d H:i:s')
            ]);
            if ($ambulanceDriver) {
                return Response::suc('Ambulance On Duty');
            } else {
                PrivateAmbulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
                where('running_status', 1)->where('driver_id', auth()->user()->id)->update([
                    'driver_id' => '',
                    'running_status' => 0,
                    'available_amenities' => $ambulanceData->available_amenities
                ]);
                return Response::err('Please try again');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function stop_duty(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'ambulance_id' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $ambulanceStatus = $this->ambulance->getApiDriverCurrentAmbulanceByAmbulanceID($request->input('ambulance_id'));
            if (!$ambulanceStatus){
                return Response::err('Invalid Data');
            }

            $ambulance = PrivateAmbulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
            where('running_status', 1)->where('driver_id', auth()->user()->id)->update([
                'driver_id' => null,
                'running_status' => 0,
            ]);
            if (!$ambulance)
                return Response::err('Something went wrong, Please try again after some time');

            $ambulanceDriver = PrivateAmbulanceDriver::where('ambulance_id', $request->input('ambulance_id'))->where('driver_id', auth()->user()->id)->update([
                'logged_out_time' => date('Y-m-d H:i:s')
            ]);
            if ($ambulanceDriver) {
                return Response::suc('Ambulance Off Duty');
            } else {
                PrivateAmbulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
                where('running_status', 0)->update([
                    'driver_id' => auth()->user()->id,
                    'running_status' => 1,
                ]);
                return Response::err('Please try again');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function save_current_coordinates(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ambulance_id' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }
            $ambulance = PrivateAmbulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
            where('running_status', 1)->where('driver_id', auth()->user()->id)->update([
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);
            if ($ambulance)
                return Response::suc('Live Coordinates Updated!');
            return Response::suc('Please try again');

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function check_driver_status(){
        try{
            $ambulance = PrivateAmbulance::where('running_status', '!=' , 0)->where('driver_id', auth()->user()->id)->get();
            return $ambulance;
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\driverApp;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\AmbulanceDriver;
use Illuminate\Http\Request;
use App\Http\Controllers\Response;
use Illuminate\Support\Facades\Validator;

class AmbulanceController extends Controller
{
    private $ambulance, $ambulance_driver;

    public function __construct()
    {
        $this->ambulance = new Ambulance();
        $this->ambulance_driver = new AmbulanceDriver();
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
            ]);
            if ($validator->fails()) {
                $errors = array_values((array)json_decode($validator->errors()));
                return Response::err($errors[0][0]);
            }

            $driverStatus = $this->ambulance->getApiDriverCurrentAmbulance();
            if ($driverStatus){
                return Response::err('Already on duty');
            }

            $ambulance = Ambulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
            where('branch_id', auth()->user()->org_id)->where('running_status', 0)->update([
                'driver_id' => auth()->user()->id,
                'running_status' => 1,
            ]);
            if (!$ambulance)
                return Response::err('Something went wrong, Please try again after some time');

            $ambulanceDriver = AmbulanceDriver::create([
                'ambulance_id' => $request->input('ambulance_id'),
                'driver_id' => auth()->user()->id,
                'logged_in_time' => date('Y-m-d H:i:s')
            ]);
            if ($ambulanceDriver) {
                return Response::suc('Ambulance On Duty');
            } else {
                Ambulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
                where('branch_id', auth()->user()->org_id)->where('running_status', 1)->where('driver_id', auth()->user()->id)->update([
                    'driver_id' => '',
                    'running_status' => 0,
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

            $ambulance = Ambulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
            where('branch_id', auth()->user()->org_id)->where('running_status', 1)->where('driver_id', auth()->user()->id)->update([
                'driver_id' => null,
                'running_status' => 0,
            ]);
            if (!$ambulance)
                return Response::err('Something went wrong, Please try again after some time');

            $ambulanceDriver = AmbulanceDriver::where('ambulance_id', $request->input('ambulance_id'))->where('driver_id', auth()->user()->id)->update([
                'logged_out_time' => date('Y-m-d H:i:s')
            ]);
            if ($ambulanceDriver) {
                return Response::suc('Ambulance Off Duty');
            } else {
                Ambulance::where('id', $request->input('ambulance_id'))->where('status', 1)->
                where('branch_id', auth()->user()->org_id)->where('running_status', 0)->update([
                    'driver_id' => auth()->user()->id,
                    'running_status' => 1,
                ]);
                return Response::err('Please try again');
            }

        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function check_driver_status(){
        try{
            $ambulance = Ambulance::where('branch_id', auth()->user()->org_id)->where('running_status', '!=' , 0)->where('driver_id', auth()->user()->id)->get();
            return $ambulance;
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\Ambulance;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\PreferredHospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreferredHospitalController extends Controller
{
    private $preferred_hospital;

    public function __construct()
    {
        $this->preferred_hospital = new PreferredHospital();
    }


    public function get_preferred_hospital()
    {
        try {
            $preferredHospitals = $this->preferred_hospital->getApiPreferredHospital();
            if ($preferredHospitals->isNotEmpty())
                return Response::suc(array('preferredHospitals' => $preferredHospitals, 'url' => asset('storage/')));
            return Response::err('No Data');
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function add_preferred_hospital(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'branch_id' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }

            $preferredH = $this->preferred_hospital->getApiPreferredHospitalByBranchID($request->input('branch_id'));
            if ($preferredH)
                return Response::err('Branch Already Added!');

            $hospital = PreferredHospital::create([
                'user_id' => auth()->user()->id,
                'branch_id' => $request->input('branch_id')
            ]);
            if ($hospital)
                return Response::suc('Preferred Hospital Added!');
            return Response::err('Please try again later');


        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function remove_preferred_hospital(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'branch_id' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }

            $hospital = PreferredHospital::where('user_id', auth()->user()->id)->where('branch_id', $request->input('branch_id'))->where('status', 1)->update([
                'status' => 0,
            ]);
            if ($hospital)
                return Response::suc('Preferred Hospital Removed!');
            return Response::err('Please try again later');


        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

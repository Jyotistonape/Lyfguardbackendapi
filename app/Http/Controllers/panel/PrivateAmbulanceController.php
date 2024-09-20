<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulanceType;
use App\Models\PrivateAmbulanceAmenity;
use App\Models\PrivateAmbulance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrivateAmbulanceController extends Controller
{
    private $ambulance, $type, $amenity;

    public function __construct()
    {
        $this->ambulance = new PrivateAmbulance();
        $this->type = new PrivateAmbulanceType();
        $this->amenity = new PrivateAmbulanceAmenity();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ambulances'] = $this->ambulance->getAllAmbulance();
        $data['pageName'] = "Ambulances";
        return view('panel.private-ambulance.list-ambulance')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Ambulance";
        $data['types'] = $this->type->getAllAmbulanceType();
        $data['amenities'] = $this->amenity->getAllAmenities();
        return view('panel.private-ambulance.create-ambulance')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_number' => 'required|unique:private_ambulances,vehicle_number',
            'type' => 'required',
            'insurance_date' => 'required',
            'registration_certificate' => 'required',
            '0_5km_rate' => 'required',
            '5_15km_rate' => 'required',
            '15_30km_rate' => 'required',
            '30_abovekm_rate' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amenitiesData = '';

        $type = $this->type->getAmbulanceTypeByID($request->input('type'));

        if (!$type)
            return Redirect::back()->with('Invalid Type');

        $ambulance = PrivateAmbulance::create([
            'admin_id' => auth()->user()->id,
            'vehicle_number' => $request->input('vehicle_number'),
            'type_id' => $request->input('type'),
            'insurance_date' => $request->input('insurance_date'),
            'registration_certificate' => $this->imageUpload($request, 'registration_certificate', 'private-ambulance/'),
            'zero_five_km_rate' => $request->input('0_5km_rate'),
            'five_fifteen_km_rate' => $request->input('5_15km_rate'),
            'fifteen_thirty_km_rate' => $request->input('15_30km_rate'),
            'thirty_above_km_rate' => $request->input('30_abovekm_rate'),
            'amenities' => $type->amenities,
            'available_amenities' => $type->amenities
        ]);
        if ($ambulance)
            return \redirect(route('listPrivateAmbulance'))->with('success', 'Ambulance Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the ambualnce.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $ambulance_info = PrivateAmbulance::where('id',$id)->latest()->first();
        if ($ambulance_info) {
            $data['types'] = $this->type->getAllAmbulanceType();
            $data['amenities'] = $this->amenity->getAllAmenities();
            $data['ambulance'] = $ambulance_info;
            $data['pageName'] = "Edit Ambulance";
            return view('panel.private-ambulance.edit-ambulance')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified private admin ambulance.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'vehicle_number' => 'required|unique:private_ambulances,vehicle_number,'.$id,
            'type' => 'required',
            'insurance_date' => 'required',
            '0_5km_rate' => 'required',
            '5_15km_rate' => 'required',
            '15_30km_rate' => 'required',
            '30_abovekm_rate' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amenitiesData = '';

        $type = $this->type->getAmbulanceTypeByID($request->input('type'));

        if (!$type)
            return Redirect::back()->with('Invalid Type');

        $amblanceData = PrivateAmbulance::where('id', $id)->where('status', 1)->latest()->first();

        $ambulance_update = PrivateAmbulance::where('id', $id)->where('status', 1)->update([
            'admin_id' => auth()->user()->id,
            'vehicle_number' => $request->input('vehicle_number'),
            'type_id' => $request->input('type'),
            'insurance_date' => $request->input('insurance_date'),
            'registration_certificate' => ($request->hasFile('registration_certificate')) ? $this->imageUpload($request, 'registration_certificate', 'private-ambulance/') :$amblanceData->registration_certificate,
            'zero_five_km_rate' => $request->input('0_5km_rate'),
            'five_fifteen_km_rate' => $request->input('5_15km_rate'),
            'fifteen_thirty_km_rate' => $request->input('15_30km_rate'),
            'thirty_above_km_rate' => $request->input('30_abovekm_rate'),
            'amenities' => $type->amenities,
            'available_amenities' => $type->amenities
        ]);
        if ($ambulance_update)
            return \redirect(route('listPrivateAmbulance'))->with('success', 'Ambulance Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified resource from private ambulance.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambulance = PrivateAmbulance::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($ambulance)
            return \redirect(route('listPrivateAmbulance'))->with('success', 'Ambulance Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

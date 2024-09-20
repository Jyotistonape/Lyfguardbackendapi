<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\AmbulanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AmbulanceController extends Controller
{
    private $ambulance, $type;

    public function __construct()
    {
        $this->ambulance = new Ambulance();
        $this->type = new AmbulanceType();
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
        return view('panel.ambulance.list-ambulance')->with('data', $data);
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
        return view('panel.ambulance.create-ambulance')->with('data', $data);
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
            'vehicle_number' => 'required|unique:ambulances,vehicle_number',
            'type' => 'required',
            'insurance_date' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $ambulance = Ambulance::create([
            'branch_id' => auth()->user()->org_id,
            'vehicle_number' => $request->input('vehicle_number'),
            'type_id' => $request->input('type'),
            'insurance_date' => $request->input('insurance_date'),
            'documents' => ($request->input('documents')) ? implode(',', $this->uploadmultipleImage($request, 'documents', 'ambulance/')) : '',
        ]);
        if ($ambulance)
            return \redirect(route('listAmbulance'))->with('success', 'Ambulance Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the ambulance.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $ambulance_info = $this->ambulance->getAmbulanceByAmbulanceID($id);
        if ($ambulance_info) {
            $data['types'] = $this->type->getAllAmbulanceType();
            $data['ambulance'] = $ambulance_info;
            $data['pageName'] = "Edit Ambulance";
            return view('panel.ambulance.edit-ambulance')->with('data', $data);
        }
        abort(404);
    }

     /**
     * Update the specified ambulance.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_number' => 'required|unique:ambulances,vehicle_number,'.$id,
            'type' => 'required',
            'insurance_date' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }


        $ambulance_update = Ambulance::where('id', $id)->where('status', 1)->update([
            'type_id' => $request->input('type'),
            'vehicle_number' => $request->input('vehicle_number'),
            'insurance_date' => $request->input('insurance_date'),
            'documents' => ($request->input('documents')) ? implode(',', $this->uploadmultipleImage($request, 'documents', 'ambulance/')) : '',
        ]);
        if ($ambulance_update)
            return \redirect(route('listAmbulance'))->with('success', 'Ambulance Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified ambulance.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambulance_delete = Ambulance::where('id', $id)->update([
            'status' => 0,
        ]);
        if ($ambulance_delete)
            return \redirect(route('listAmbulance'))->with('success', 'Ambulance Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

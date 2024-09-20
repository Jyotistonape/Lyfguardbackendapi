<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\AmbulanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AmbulanceTypeController extends Controller
{
    private $type;

    public function __construct()
    {
        $this->type = new AmbulanceType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['types'] = $this->type->getAllAmbulanceType();
        $data['pageName'] = "Ambulance Types";
        return view('panel.ambulance-type.list-type')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Ambulance Type";
        return view('panel.ambulance-type.create-type')->with('data', $data);
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
            'name' => 'required',
            'image' => 'required',
//            'description' => 'required',
            'price' => 'required',
            'maximum_kilometre' => 'required',
            'minimum_kilometre' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $type = AmbulanceType::create([
            'slug' => $this->generateSlug($request->input('name'), 'ambulance_types'),
            'name' => $request->input('name'),
            'description' => ($request->input('description')) ? $request->input('description') : '',
            'price' => $request->input('price'),
            'image' => $this->imageUpload($request, 'image', 'ambulance_types/'),           
            'has_amenity' => ($request->input('has_amenity')) ? 1 : 0,
            'minimum_kilometre' => $request->input('minimum_kilometre'),
            'maximum_kilometre' => $request->input('maximum_kilometre'),
        ]);
        if ($type)
            return \redirect(route('listAmbulanceType'))->with('success', 'Ambulance Type Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = $this->type->getAmbulanceTypeByID($id);
        if ($type) {
            $data['type'] = $type;
            $data['pageName'] = "Edit Ambulance Type";
            return view('panel.ambulance-type.edit-type')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
//            'image' => 'required',
//            'description' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $typeData = $this->type->getAmbulanceTypeByID($id);
        if (!$typeData)
            return Redirect::back()->with('error', 'Invalid Amenity');

        $type = AmbulanceType::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'description' => ($request->input('description')) ? $request->input('description') : $typeData->description,
            'price' => $request->input('price'),
            'image' => ($request->hasFile('image')) ? $this->imageUpload($request, 'image', 'amenities/') : $typeData->image,
            'has_amenity' => ($request->input('has_amenity')) ? 1 : 0,
            'minimum_kilometre' => $request->input('minimum_kilometre'),
            'maximum_kilometre' => $request->input('minimum_kilometre'),
        ]);
        if ($type)
            return \redirect(route('listAmbulanceType'))->with('success', 'Ambulance Type Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = AmbulanceType::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($type)
            return Redirect::back()->with('success', 'Ambulance Type Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }


    public function get_ambulance_type_by_id(Request $request){
        $typeID = $request->input('type_id');
        return $this->type->getAmbulanceTypeByID($typeID);
    }
}

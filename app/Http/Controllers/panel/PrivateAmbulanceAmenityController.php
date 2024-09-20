<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulanceAmenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrivateAmbulanceAmenityController extends Controller
{
    private $amenity;

    public function __construct()
    {
        $this->amenity = new PrivateAmbulanceAmenity();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['amenities'] = $this->amenity->getAllAmenities();
        $data['pageName'] = "Private Ambulance Amenities";
        return view('panel.private-ambulance-amenity.list-amenity')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Private Ambulance Amenity";
        return view('panel.private-ambulance-amenity.create-amenity')->with('data', $data);
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
           'description' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amenity = PrivateAmbulanceAmenity::create([
            'slug' => $this->generateSlug($request->input('name'), 'private_ambulance_amenities'),
            'name' => $request->input('name'),
           'description' => $request->input('description'),
             'price' => $request->input('price'),
           'image' => $this->imageUpload($request, 'image', 'private-ambulance-amenities/'),
        ]);
        if ($amenity)
            return \redirect(route('listPrivateAmbulanceAmenity'))->with('success', 'Private Ambulance Amenity Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the private ambulance amenity.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $amenity_info = $this->amenity->getAmenityByID($id);
        if ($amenity_info) {
            $data['amenity'] = $amenity_info;
            $data['pageName'] = "Edit Private Ambulance Amenity";
            return view('panel.private-ambulance-amenity.edit-amenity')->with('data', $data);
        }
        abort(404);
    }

     /**
     * Update the specified private ambulance amenity.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $amenity_update = PrivateAmbulanceAmenity::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
        ]);
        if ($amenity_update)
            return \redirect(route('listPrivateAmbulanceAmenity'))->with('success', 'Private Ambulance Amenity Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified private ambulance amenity.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $amenity_delete = PrivateAmbulanceAmenity::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($amenity_delete)
            return Redirect::back()->with('success', 'Private Ambulance Amenity Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AmenityController extends Controller
{
    private $amenity;

    public function __construct()
    {
        $this->amenity = new Amenity();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['amenities'] = $this->amenity->getAllAmenities();
        $data['pageName'] = "Amenities";
        return view('panel.amenity.list-amenity')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Amenity";
        return view('panel.amenity.create-amenity')->with('data', $data);
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
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $amenity = Amenity::create([
            'slug' => $this->generateSlug($request->input('name'), 'amenities'),
            'name' => $request->input('name'),
            'description' => ($request->input('description')) ? $request->input('description') : '',
            'price' => $request->input('price'),
            'image' => $this->imageUpload($request, 'image', 'amenities/'),
        ]);
        if ($amenity)
            return \redirect(route('listAmenity'))->with('success', 'Amenity Added');
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
        $amenity = $this->amenity->getAmenityByID($id);
        if ($amenity) {
            $data['amenity'] = $amenity;
            $data['pageName'] = "Edit Amenity";
            return view('panel.amenity.edit-amenity')->with('data', $data);
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

        $amenityData = $this->amenity->getAmenityByID($id);
        if (!$amenityData)
            return Redirect::back()->with('error', 'Invalid Amenity');

        $amenity = Amenity::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'description' => ($request->input('description')) ? $request->input('description') : $amenityData->description,
            'price' => $request->input('price'),
            'image' => ($request->hasFile('image')) ? $this->imageUpload($request, 'image', 'amenities/') : $amenityData->image,
        ]);
        if ($amenity)
            return \redirect(route('listAmenity'))->with('success', 'Amenity Updated');
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
        $amenity = Amenity::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($amenity)
            return Redirect::back()->with('success', 'Amenity Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

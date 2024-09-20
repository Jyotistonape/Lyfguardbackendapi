<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingType;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    private $type, $listing;

    public function __construct()
    {
        $this->type = new ListingType();
        $this->listing = new Listing();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($typeID)
    {
        $data['listings'] = $this->listing->getAllListing($typeID);
        if ($typeID == 1){
            $pageName = "Police Listing";
        } elseif ($typeID == 2){
            $pageName = "Fire Listing";
        } elseif ($typeID == 3){
            $pageName = "Blood Bank Listing";
        } else{
            $pageName = "Listing";
        }
        $data['pageName'] = $pageName;
        return view('panel.listing.list-listing')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Listing";
        $data['types'] = $this->type->getAllType();
        return view('panel.listing.create-listing')->with('data', $data);
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
//            'phone' => 'required',
//            'email' => 'required',
            'address_line1' => 'required',
//            'address_line2' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
//            'website' => 'required',
            'type' => 'required',
//            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $listing = Listing::create([
            'slug' => $this->generateSlug($request->input('name'), 'listings'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'phone2' => ($request->input('phone2')) ? $request->input('phone2') : '',
            'phone3' => ($request->input('phone3')) ? $request->input('phone3') : '',
            'email' => ($request->input('email')) ? $request->input('email') : '',
//            'email' => $request->input('email'),
            'address_line1' => $request->input('address_line1'),
            'address_line2' => ($request->input('address_line2')) ? $request->input('address_line2') : '',
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'pincode' => ($request->input('pincode')) ? $request->input('pincode') : 0,
            'website' => ($request->input('website')) ? $request->input('website') : '',
//            'website' => $request->input('website'),
            'type_id' => $request->input('type'),
            'image' => ($request->hasFile('image')) ? $this->imageUpload($request, 'image', 'listings/') : '',
        ]);
        if ($listing)
            return \redirect(route('listListing', $request->input('type')))->with('success', 'Listing Added');
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
        $listing = $this->listing->getListingByID($id);
        if ($listing) {
            $data['listing'] = $listing;
            $data['pageName'] = "Edit Listing";
            $data['types'] = $this->type->getAllType();
            return view('panel.listing.edit-listing')->with('data', $data);
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
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
//            'email' => 'required',
            'address_line1' => 'required',
//            'address_line2' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
//            'latitude' => 'required',
//            'longitude' => 'required',
//            'website' => 'required',
            'type' => 'required',
//            'image' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $listingData = $this->listing->getListingByID($id);
        if (!$listingData)
            return Redirect::back()->with('error', 'Invalid Listing');

        $listing = Listing::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'phone2' => ($request->input('phone2')) ? $request->input('phone2') : '',
            'phone3' => ($request->input('phone3')) ? $request->input('phone3') : '',
//            'email' => $request->input('email'),
            'email' => ($request->input('email')) ? $request->input('email') : $listingData->email,
            'address_line1' => $request->input('address_line1'),
            'address_line2' => ($request->input('address_line2')) ? $request->input('address_line2') : '',
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'latitude' => $request->input('lat'),
            'longitude' => $request->input('long'),
            'pincode' => ($request->input('pincode')) ? $request->input('pincode') : $listingData->pincode,
//            'website' => $request->input('website'),
            'website' => ($request->input('website')) ? $request->input('website') : $listingData->website,
            'type_id' => $request->input('type'),
            'image' => ($request->hasFile('image')) ? $this->imageUpload($request, 'image', 'listings/') : $listingData->image,
        ]);
        if ($listing)
            return \redirect(route('listListing', $request->input('type')))->with('success', 'Listing Updated');
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
        $listing = Listing::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($listing)
            return Redirect::back()->with('success', 'Listing Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }

}

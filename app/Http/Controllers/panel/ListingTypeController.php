<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\ListingType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ListingTypeController extends Controller
{
    private $type;

    public function __construct()
    {
        $this->type = new ListingType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['types'] = $this->type->getAllType();
        $data['pageName'] = "Listing Types";
        return view('panel.listing-type.list-type')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Listing Type";
        return view('panel.listing-type.create-type')->with('data', $data);
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
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $type = ListingType::create([
            'slug' => $this->generateSlug($request->input('name'), 'listing_types'),
            'name' => $request->input('name'),
            'image' => $this->imageUpload($request, 'image', 'listingtypes/'),
        ]);
        if ($type)
            return \redirect(route('listListingType'))->with('success', 'Listing Type Added');
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
        $type = $this->type->getTypeByID($id);
        if ($type) {
            $data['type'] = $type;
            $data['pageName'] = "Edit Listing Type";
            return view('panel.listing-type.edit-type')->with('data', $data);
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
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $typeData = $this->type->getTypeByID($id);
        if (!$typeData)
            return Redirect::back()->with('error', 'Invalid Type');

        
        $type = ListingType::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'image' => ($request->hasFile('image')) ? $this->imageUpload($request, 'image', 'listingtypes/') : $typeData->image,
        ]);
        if ($type)
            return \redirect(route('listListingType'))->with('success', 'Listing Type Updated');
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
        $type = ListingType::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($type)
            return Redirect::back()->with('success', 'Listing Type Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

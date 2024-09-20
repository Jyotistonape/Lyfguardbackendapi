<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\PrivateAmbulanceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrivateAmbulanceTypeController extends Controller
{
    private $type;

    public function __construct()
    {
        $this->type = new PrivateAmbulanceType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['types'] = $this->type->getAllAmbulanceType();
        $data['pageName'] = "Private Ambulance Types";
        return view('panel.private-ambulance-type.list-type')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Private Ambulance Type";
        return view('panel.private-ambulance-type.create-type')->with('data', $data);
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
//            'image' => 'required',
//            'description' => 'required',
//            'price' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $type = PrivateAmbulanceType::create([
            'slug' => $this->generateSlug($request->input('name'), 'private_ambulance_types'),
            'name' => $request->input('name')
            // 'has_amenity' => ($request->input('has_amenity')) ? 1 : 0,
//            'description' => ($request->input('description')) ? $request->input('description') : '',
//            'price' => $request->input('price'),
//            'image' => $this->imageUpload($request, 'image', 'ambulance_types/'),
        ]);
        if ($type)
            return \redirect(route('listPrivateAmbulanceType'))->with('success', 'Private Ambulance Type Added');
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


    public function get_ambulance_type_by_id(Request $request){
        $typeID = $request->input('type_id');
        return $this->type->getAmbulanceTypeByID($typeID);
    }

    /**
     * Show the form for editing the private ambulance type.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
          
        $type = $this->type->getAmbulanceTypeByID($id);
        if ($type) {
            $data['type'] = $type;
            $data['pageName'] = "Edit Private Ambulance Type";
            return view('panel.private-ambulance-type.edit-type')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified private ambulance type.
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

        $type = PrivateAmbulanceType::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
        ]);
        if ($type)
            return \redirect(route('listPrivateAmbulanceType'))->with('success', 'Private Ambulance Type Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified private ambulance type.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = PrivateAmbulanceType::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($category)
            return Redirect::back()->with('success', 'Private Ambulance Type Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

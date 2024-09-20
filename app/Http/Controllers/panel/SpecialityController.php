<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\BranchType;
use App\Models\Speciality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SpecialityController extends Controller
{
    private $speciality, $branch_type;

    public function __construct(){
        $this->speciality = new Speciality();
        $this->branch_type = new BranchType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $data['specialities'] = $this->speciality->getAllSpeciality();
        $data['pageName'] = "Specialities";
        return view('panel.speciality.list-speciality')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Speciality";
        $data['types'] = $this->branch_type->getAllType();
        return view('panel.speciality.create-speciality')->with('data', $data);
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
            'branch_type' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $speciality = Speciality::create([
            'slug' => $this->generateSlug($request->input('name'), 'specialities'),
            'name' => $request->input('name'),
            'branch_type_id' => $request->input('branch_type'),
        ]);
        if ($speciality)
            return \redirect(route('listSpeciality'))->with('success', 'Speciality Added');
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


    public function edit($id){
        $speciality = $this->speciality->getSpecialityByID($id);
        if($speciality) {
            $data['pageName'] = "Edit Branch";
            $data['types'] = $this->branch_type->getAllType();
            $data['speciality'] = $speciality;
            return view('panel.speciality.edit-speciality')->with('data', $data);
        }
        abort(404);
    }


    // Update Branch
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'branch_type' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $speciality = Speciality::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('name'),
            'branch_type_id' => $request->input('branch_type'),
        ]);
        if ($speciality)
            return \redirect(route('listSpeciality'))->with('success', 'Speciality Updated');
        return Redirect::back()->with('error', 'Please try again');
    }


    public function destroy($id){
        $speciality = Speciality::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($speciality)
            return Redirect::back()->with('success', 'Speciality Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }

    public function get_speciality_by_branch_type_id(Request $request){
        $branchTypeID = $request->input('branch_type_id');
        return $this->speciality->getAllSpeciality($branchTypeID);
    }
}

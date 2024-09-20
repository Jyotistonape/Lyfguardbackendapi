<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchType;
use App\Models\EmergencyType;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    private $branch, $branch_type, $hospital, $emergency_type;

    public function __construct(){
        $this->branch = new Branch();
        $this->hospital = new Hospital();
        $this->branch_type = new BranchType();
        $this->emergency_type = new EmergencyType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $data['branches'] = $this->branch->getAllBranch();
        $data['pageName'] = "Branches";
        
        return view('panel.branch.list-branch')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Branch";
        $data['types'] = $this->branch_type->getAllType();
        $data['hospitals'] = $this->hospital->getAllHospital();
        $data['emergencyTypes'] = $this->emergency_type->getAllType();
        return view('panel.branch.create-branch')->with('data', $data);
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
            'branch_name' => 'required',
            'type' => 'required',
            'speciality_ids' => 'required',
            'is_partner' => 'required',
            'emergency_types' => 'required',
            'phone' => 'required',
            'address_line1' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $branch = Branch::create([
            'hospital_id' => (auth()->user()->role == 1) ? $request->input('hospital') : auth()->user()->org_id,
            'slug' => $this->generateSlug($request->input('branch_name'), 'branches'),
            'name' => $request->input('branch_name'),
            'type_id' => $request->input('type'),
            'is_partner' => $request->input('is_partner'),
            'speciality_ids' => implode(',', $request->input('speciality_ids')),
            'emergency_type_ids' => implode(',', $request->input('emergency_types')),
            'website' => ($request->input('website')) ? $request->input('website') : '',
            'phone' => $request->input('phone'),
            'address_line1' => $request->input('address_line1'),
            'address_line2' => ($request->input('address_line2')) ? $request->input('address_line2') : '',
            'country' => $request->input('country'),
            'state' => $request->input('state'),
            'city' => $request->input('city'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'pincode' => ($request->input('pincode')) ? $request->input('pincode') : 0,
            'is_emergency' => ($request->input('is_emergency')) ? 1 : 0,
        ]);
        if (!$branch)
            return Redirect::back()->with('error', 'Please try again');

        $user = User::create([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 4,
            'image' => 'user.png',
            'org_id' => $branch->id
        ]);
        if ($user) {
            return \redirect(route('listBranch'))->with('success', 'Branch Added');
        } 
        else {
            Branch::destroy($branch->id);
            return Redirect::back()->with('error', 'Please try again');
        }
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
        $branch = Branch::find($id);

        
   
        

        $data['pageName'] = "Edit Branch";
        $data['types'] = $this->branch_type->getAllType();
        $data['hospitals'] = $this->hospital->getAllHospital();
        $data['emergencyTypes'] = $this->emergency_type->getAllType();

        
        return view('panel.branch.edit-branch')->with('data', $data)->with('branch', $branch);
    }


    // Update Branch
    public function update(Request $request, $id){

        $branch = Branch::find($id);

        $branch['hospital_id'] = (auth()->user()->role == 1) ? $request->input('hospital') : auth()->user()->org_id;
        $branch['slug'] = $this->generateSlug($request->input('branch_name'), 'branches');
        $branch['name'] = $request->input('branch_name');
        $branch['type_id'] = $request->input('type');
        $branch['is_partner'] = $request->input('is_partner');
        $branch['speciality_ids'] = implode(',', $request->input('speciality_ids'));
        $branch['emergency_type_ids'] = implode(',', $request->input('emergency_types'));
        $branch['website'] = ($request->input('website')) ? $request->input('website') : '';
        $branch['phone'] = $request->input('phone');
        $branch['address_line1'] = $request->input('address_line1');
        $branch['address_line2'] = ($request->input('address_line2')) ? $request->input('address_line2') : '';
        $branch['country'] = $request->input('country');
        $branch['state'] = $request->input('state');
        $branch['city'] = $request->input('city');
        $branch['latitude'] = $request->input('latitude');
        $branch['longitude'] = $request->input('longitude');
        $branch['pincode'] = ($request->input('pincode')) ? $request->input('pincode') : 0;
        $branch['is_emergency'] = ($request->input('is_emergency')) ? 1 : 0;

        $branch->getAdminDetails->name = $request->input('name');
        $branch->getAdminDetails->slug = $this->generateSlug($request->input('name'), 'users');
        $branch->getAdminDetails->username = $request->input('username');
        if($request->input('password')){
            $branch->getAdminDetails->password = Hash::make($request->input('password'));
        }
        $branch->getAdminDetails->update();

        $branch->update();

        return \redirect(route('listBranch'))->with('success', 'Branch Updated');
    }


    public function destroy($id){
        $type = Branch::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($type)
            return Redirect::back()->with('success', 'Branch Type Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
}

<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    private $hospital, $hospital_type;

    public function __construct()
    {
        $this->hospital = new Hospital();
        $this->hospital_type = new HospitalType();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['hospitals'] = $this->hospital->getAllHospital();
        $data['pageName'] = "Hospitals";
        return view('panel.hospital.list-hospital')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Hospital";
        $data['types'] = $this->hospital_type->getAllType();
        return view('panel.hospital.create-hospital')->with('data', $data);
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
            'hospital_name' => 'required',
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
//            'logo' => 'required',
//            'banner' => 'required',
//            'website' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $hospital = Hospital::create([
            'slug' => $this->generateSlug($request->input('hospital_name'), 'hospitals'),
            'name' => $request->input('hospital_name'),
            'logo' => ($request->hasFile('logo')) ? $this->imageUpload($request, 'logo', 'hospitals/') : '',
            'banner' => ($request->hasFile('banner')) ? $this->imageUpload($request, 'banner', 'hospitals/') : '',
//            'logo' => $this->imageUpload($request, 'logo', 'hospitals/'),
//            'banner' => $this->imageUpload($request, 'banner', 'hospitals/'),
//            'website' => $request->input('website'),
            'website' => ($request->input('website')) ? $request->input('website') : '',
            'type_id' => $request->input('type'),
        ]);
        if (!$hospital)
            return Redirect::back()->with('error', 'Please try again');

        $user = User::create([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 3,
            'image' => 'user.png',
            'org_id' => $hospital->id
        ]);
        if ($user) {
            return \redirect(route('listHospital'))->with('success', 'Hospital Added');
        } else {
            Hospital::destroy($hospital->id);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hospital = $this->hospital->getHospitalByID($id);
        if ($hospital) {
            $data['hospital'] = $hospital;
            $data['pageName'] = "Edit Hospital";
            $data['types'] = $this->hospital_type->getAllType();
            return view('panel.hospital.edit-hospital')->with('data', $data);
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
            'hospital_name' => 'required',
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $request->input('admin_id'),
//            'website' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $hospitalData = $this->hospital->getHospitalByID($id);
        if (!$hospitalData)
            return Redirect::back()->with('error', 'Invalid Hospital');

        $hospital = Hospital::where('id', $id)->where('status', 1)->update([
            'name' => $request->input('hospital_name'),
            'logo' => ($request->hasFile('logo')) ? $this->imageUpload($request, 'logo', 'hospitals/') : $hospitalData->logo,
            'banner' => ($request->hasFile('banner')) ? $this->imageUpload($request, 'banner', 'hospitals/') : $hospitalData->banner,
//            'website' => $request->input('website'),
            'website' => ($request->input('website')) ? $request->input('website') : $hospitalData->website,
            'type_id' => $request->input('type'),
        ]);
        if ($hospital) {
            $user = User::where('id', $request->input('admin_id'))->where('status', 1)->where('role', 3)->update([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
            ]);
            if ($user)
                return \redirect(route('listHospital'))->with('success', 'Hospital Updated');
            return Redirect::back()->with('error', 'Please try again');
        } else {
            return Redirect::back()->with('error', 'Please try again after sometime');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hospital = Hospital::where('id', $id)->where('status', 1)->update([
            'status' => 0,
        ]);
        if ($hospital) {
            User::where('org_id', $id)->where('status', 1)->where('role', 3)->update([
                'status' => 0,
            ]);
            return Redirect::back()->with('success', 'Hospital Deleted');
        } else {
            return Redirect::back()->with('error', 'Please try again');
        }
    }
}

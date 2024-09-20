<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\DriverDetail;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    private $driver;

    public function __construct()
    {
        $this->driver = new DriverDetail();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['drivers'] = $this->driver->getAllDriver();
        $data['pageName'] = "Drivers";
        return view('panel.driver.list-driver')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Driver";
        return view('panel.driver.create-driver')->with('data', $data);
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
//            'email' => 'required',
            'licence_number' => 'required',
            'blood_group' => 'required',
//             'address_line1' => 'required',
// //            'address_line2' => 'required',
//             'country' => 'required',
//             'state' => 'required',
//             'city' => 'required',
//             'latitude' => 'required',
//             'longitude' => 'required',
            'username' => 'required|unique:users,username',
//            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('username')),
            'role' => 6,
            'image' => 'user.png',
            'org_id' => auth()->user()->org_id 
        ]);
        if (!$user)
            return Redirect::back()->with('error', 'Please try again');

        $userDetails = DriverDetail::create([
            'user_id' => $user->id,
            'name' => $request->input('name'),
            'phone' => $request->input('username'),
            'licence_number' => $request->input('licence_number'),
            'blood_group' => $request->input('blood_group'),
            // 'address_line1' => $request->input('address_line1'),
            // 'address_line2' => ($request->input('address_line2')) ? $request->input('address_line2') : '',
            // 'country' => $request->input('country'),
            // 'state' => $request->input('state'),
            // 'city' => $request->input('city'),
            // 'latitude' => $request->input('latitude'),
            // 'longitude' => $request->input('longitude'),
            // 'pincode' => ($request->input('pincode')) ? $request->input('pincode') : 0,
        ]);
        if ($userDetails) {
            return \redirect(route('listDriver'))->with('success', 'Driver Added');
        } else {
            User::destroy($user->id);
            return Redirect::back()->with('error', 'Please try again');
        }
    }

    /**
     * Show the form for editing the driver.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $driver_info = DriverDetail::where('id',$id)->latest()->first();
        if ($driver_info) {
            $data['driver'] = $driver_info;
            $data['pageName'] = "Edit Driver";
            return view('panel.driver.edit-driver')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified driver.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'licence_number' => 'required',
            'blood_group' => 'required',
            'username' => 'required|unique:users,username,'.$id
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        
        $driver_info = DriverDetail::where('id',$id)->where('status',1)->latest()->first();
        $driver_update = DriverDetail::where('id',$id)->where('status',1)->update([
            'name' => $request->input('name'),
            'phone' => $request->input('username'),
            'licence_number' => $request->input('licence_number'),
            'blood_group' => $request->input('blood_group'),
        ]);

        if($driver_update)
        {

            $user_update = User::where('role',6)->where('id',$driver_info->user_id)->where('status', 1)->update([
                'slug' => $this->generateSlug($request->input('name'), 'users'),
                'name' => $request->input('name'),
                'username' => $request->input('username'),
            ]);

            if ($user_update)
            {
                return \redirect(route('listDriver'))->with('success', 'Driver Updated');
            }
            else
            {
                return Redirect::back()->with('error', 'Please try again');
            } 
        }
        else
        {
            return Redirect::back()->with('error', 'Please try again');
        }
        
    }

    /**
     * Remove the specified driver.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver_delete = DriverDetail::where('id',$id)->update([
            'status' => 0,
        ]);
        if ($driver_delete)
            return \redirect(route('listDriver'))->with('success', 'Driver Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrivateAmbulanceBookingManagerController extends Controller
{
    
    public function index()
    {
        $data['users'] = User::where('status', 1)->where('role', 11)->where('org_id', auth()->user()->id)->get();
        $data['pageName'] = "Booking Manager";
        return view('panel.private-ambulance-booking-manager.list-user')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Booking Manager";
        return view('panel.private-ambulance-booking-manager.create-user')->with('data', $data);
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
            'username' => 'required|unique:users,username',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $users = User::where('status', 1)->where('role', 11)->where('org_id', auth()->user()->id)->get()->count();
        if ($users > 0)
            return Redirect::back()->with('error', 'Already Booking Manager Added');

        $user = User::create([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('username')),
            'role' => 11,
            'image' => 'user.png',
            'org_id' => auth()->user()->id
        ]);
        if ($user)
            return \redirect(route('listPrivateAmbulanceBookingManager'))->with('success', 'Booking Manager Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the private ambulance booking manager.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $private_ambulance_booking_manager_info = User::where('role',11)->where('id',$id)->latest()->first();
        if ($private_ambulance_booking_manager_info) {
            $data['private_ambulance_booking_manager'] = $private_ambulance_booking_manager_info;
            $data['pageName'] = "Edit Booking Manager";
            return view('panel.private-ambulance-booking-manager.edit-user')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified private ambulance booking manager.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user_update = User::where('role',11)->where('id',$id)->update([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
        ]);

        if ($user_update)
            return \redirect(route('listPrivateAmbulanceBookingManager'))->with('success', 'Booking Manager Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

     /**
     * Remove the specified private ambulance booking manager.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_delete = User::where('role',11)->where('id',$id)->update([
            'status' => 0,
        ]);
        if ($user_delete)
            return \redirect(route('listPrivateAmbulanceBookingManager'))->with('success', 'Booking Manager Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}
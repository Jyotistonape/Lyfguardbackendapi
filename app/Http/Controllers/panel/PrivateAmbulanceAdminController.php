<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PrivateAmbulanceAdminController extends Controller
{

    public function index()
    {
        $data['users'] = User::where('status', 1)->where('role', 9)->get();
        $data['pageName'] = "Private Ambulance Admin";
        return view('panel.private-ambulance-admin.list-user')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Private Ambulance Admin";
        return view('panel.private-ambulance-admin.create-user')->with('data', $data);
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
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 9,
            'image' => 'user.png',
        ]);
        if ($user)
            return \redirect(route('listPrivateAmbulanceAdmin'))->with('success', 'Private Ambulance Admin Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the private ambulance admin.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user_info = User::where('id',$id)->where('role', 9)->latest()->first();
        if ($user_info) {
            $data['user'] = $user_info;
            $data['pageName'] = "Edit Private Ambulance Admin";
            return view('panel.private-ambulance-admin.edit-user')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified private ambulance admin.
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
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user_update = User::where('id', $id)->where('role', 9)->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);
        if ($user_update)
            return \redirect(route('listPrivateAmbulanceAdmin'))->with('success', 'Private Ambulance Admin Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified private ambulance admin.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $amenity_delete = User::where('id', $id)->where('role', 9)->update([
            'status' => 0,
        ]);
        if ($amenity_delete)
            return Redirect::back()->with('success', 'Private Ambulance Admin Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

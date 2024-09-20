<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomerSupportManagerController extends Controller
{
    
    public function index()
    {
        $data['users'] = User::where('status', 1)->where('role', 12)->get();
        $data['pageName'] = "Customer Support Manager";
        return view('panel.customer-support-manager.list-user')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Customer Support Manager";
        return view('panel.customer-support-manager.create-user')->with('data', $data);
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
            'username' => 'required|email|unique:users,username',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 12,
            'image' => 'user.png',
        ]);
        if ($user)
            return \redirect(route('listCustomerSupport'))->with('success', 'Customer Support Manager Added');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Show the form for editing the customer support manager.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user_info = User::where('id',$id)->where('role', 12)->latest()->first();
        if ($user_info) {
            $data['user'] = $user_info;
            $data['pageName'] = "Edit Customer Support Manager";
            return view('panel.customer-support-manager.edit-user')->with('data', $data);
        }
        abort(404);
    }

    /**
     * Update the specified customer support manager.
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

        $user_update = User::where('id', $id)->where('role', 12)->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);
        if ($user_update)
            return \redirect(route('listCustomerSupport'))->with('success', 'Customer Support Manager Updated');
        return Redirect::back()->with('error', 'Please try again');
    }

    /**
     * Remove the specified customer support manager.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $amenity_delete = User::where('id', $id)->where('role', 12)->update([
            'status' => 0,
        ]);
        if ($amenity_delete)
            return Redirect::back()->with('success', 'Customer Support Manager Deleted');
        return Redirect::back()->with('error', 'Please try again');
    }
}

<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomerAssistManagerController extends Controller
{
    
    public function index()
    {
        $data['users'] = User::where('status', 1)->where('role', 13)->where('org_id', auth()->user()->org_id)->get();
        $data['pageName'] = "Customer Assist Manager";
        return view('panel.customer-assist-manager.list-user')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['pageName'] = "Add Customer Assist Manager";
        return view('panel.customer-assist-manager.create-user')->with('data', $data);
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
            // 'password' => 'required'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::create([ 
            'slug' => $this->generateSlug($request->input('name'), 'users'),
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('username')),
            'role' => 13,
            'image' => 'user.png',
            'org_id' => auth()->user()->org_id
        ]);
        if ($user)
            return \redirect(route('listCustomerAssist'))->with('success', 'Customer Assist Manager Added');
        return Redirect::back()->with('error', 'Please try again');
    }
}

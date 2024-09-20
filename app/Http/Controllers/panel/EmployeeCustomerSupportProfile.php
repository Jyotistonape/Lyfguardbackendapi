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
}

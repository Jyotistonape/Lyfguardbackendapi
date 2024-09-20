<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(){
        $data['pageName'] = "Home";
        return view('frontend.home')->with('data', $data)->with('home', true);
    }

    public function privacy_policy(){
        $data['pageName'] = "Privacy Policy";
        return view('frontend.privacy-policy')->with('data', $data);
    }

    public function terms_and_conditions(){
        $data['pageName'] = "Terms & Conditions";
        return view('frontend.terms-and-conditions')->with('data', $data);
    }
}

<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = new UserDetail();
    }

    public function index()
    {
        $data['users'] = $this->user->getAllUser();
        $data['pageName'] = "Users";
        return view('panel.user.list-user')->with('data', $data);
    }
}

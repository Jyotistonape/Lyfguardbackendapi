<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Response;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function update_profile(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
//                'gender' => 'required',
//                'blood_group' => 'required',
//                'dob' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $user = User::where('id', auth()->user()->id)->where('status', 1)->where('role', 8)->update([
                'name' => $request->input('name'),
            ]);
            if ($user){
                $userData = UserDetail::where('user_id', auth()->user()->id)->where('status', 1)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'gender' => ($request->input('gender')) ? $request->input('gender') : null,
                    'blood_group' => ($request->input('blood_group')) ? $request->input('blood_group') : null,
                    'dob' => ($request->input('dob')) ? $request->input('dob') : null,
                ]);
                return $this->get_profile();
            } else{
                return Response::err('Please try again');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }


    public function get_profile()
    {
        try {
            $user = User::where('id', auth()->user()->id)->where('status', 1)->where('role', 8)->first();
            if ($user) {
                $userData = UserDetail::where('status', 1)->where('user_id', $user->id)->first();
                return Response::suc(array('user' => $user, 'userDetails' => $userData, 'url' => asset('storage/')));
            } else{
                return Response::err('Invalid');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }
}

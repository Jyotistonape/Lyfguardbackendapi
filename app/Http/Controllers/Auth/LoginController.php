<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/panel/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['username' => $request->{$this->username()}, 'password' => $request->password, 'status' => 1];
    }

    public function api_login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                'fcm_token' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', 8)->first();

            if ($user){
                $userData = UserDetail::where('status', 1)->where('user_id', $user->id)->first();
                if (!$userData){
                    $userdetails = UserDetail::create([
                        'user_id' => $user->id,
                        'phone' => $request->input('phone'),
                    ]);
                } else{
                    $userdetails = $userData;
                }
                $token = JWTAuth::fromUser($user);
                User::where('id', $user->id)->update(['fcm_token' => $request->input('fcm_token'), 'otp' => null]);
                return Response::suc(array('user' => $user, 'userDetails' => $userdetails, 'token' => $token, 'url' => asset('storage/')));

            } else{
                return Response::err('Invalid Credentials');
            }
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function api_booking_manager_login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                'fcm_token' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', 5)->first();
            if (empty($user))
                return Response::err('Invalid Credentials');

            $token = JWTAuth::fromUser($user);
            User::where('id', $user->id)->update(['fcm_token' => $request->input('fcm_token'), 'otp' => null, 'duty_status' => 1]);
            return Response::suc(array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function api_driver_login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                'fcm_token' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', 6)->first();
            if (empty($user))
                return Response::err('Invalid Credentials');

            $token = JWTAuth::fromUser($user);
            User::where('id', $user->id)->update(['fcm_token' => $request->input('fcm_token'), 'otp' => null]);
            return Response::suc(array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function api_private_driver_login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                'fcm_token' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', 10)->first();
            if (empty($user))
                return Response::err('Invalid Credentials');

            $token = JWTAuth::fromUser($user);
            User::where('id', $user->id)->update(['fcm_token' => $request->input('fcm_token'), 'otp' => null]);
            return Response::suc(array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function api_private_booking_manager_login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                'fcm_token' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', 11)->first();
            if (empty($user))
                return Response::err('Invalid Credentials');

            $token = JWTAuth::fromUser($user);
            User::where('id', $user->id)->update(['fcm_token' => $request->input('fcm_token'), 'otp' => null]);
            return Response::suc(array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function api_customer_assist_manager_login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'otp' => 'required',
                // 'fcm_token' => 'required',
            ]);
            if ($validator->fails()) {
                $erros = array_values((array)json_decode($validator->errors()));
                return Response::err($erros[0][0]);
            }
            $otp = $request->input('otp');
            $user = User::where('username', $request->input('phone'))->where('otp', $otp)->where('status', 1)->where('role', 13)->first();
            if (empty($user))
                return Response::err('Invalid Credentials');

            $token = JWTAuth::fromUser($user);
            User::where('id', $user->id)->update(['otp' => null]);
            return Response::suc(array('user' => $user, 'token' => $token));
        } catch (\Exception $e) {
            return Response::err($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
         $this->guard()->logout();
         $request->session()->flush();
         $request->session()->regenerate();
         return redirect('/login');
    }
}

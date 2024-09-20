<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\BranchType;
use App\Models\HospitalType;
use App\Models\ListingType;
use App\Models\Booking;
use App\Models\DriverDetail;
use App\Models\Ambulance;
use App\Models\PrivateAmbulance;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Branch;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $booking, $ambulance, $private_ambulance, $user_detail, $hospital, $branch, $driver;
    public function __construct(){
        $this->booking = new Booking();
        $this->ambulance = new Ambulance();
        $this->private_ambulance = new PrivateAmbulance();
        $this->user_detail = new UserDetail();
        $this->hospital = new Hospital();
        $this->branch = new Branch();
        $this->driver = new DriverDetail();
    }

    public function index(Request $request){

        
        if($request->type!="")
        {
            $data['redirect_to'] = $request->type;
        }
        $data['pageName'] = "Dashboard";
        $data['bookings'] = $this->booking->getAllBooking(0)->count();
        $data['cancelBookings'] = $this->booking->getAllBooking(6)->count();
        $data['onGoingBookings'] = $this->booking->getAllBooking(3)->count();
        $data['completedBookings'] = $this->booking->getAllBooking(5)->count();
        $data['users'] = $this->user_detail->getAllUser()->count();
        $data['drivers'] = $this->driver->getAllDriver()->count();
        $data['ambulances'] = $this->ambulance->getAllAmbulance()->count();
        $data['branches'] = $this->branch->getAllBranch()->count();
        if(auth()->user()->role == 3){
        $data['walletBalance'] = $this->hospital->getHospitalByID(auth()->user()->org_id)->wallet_balance;
        $data['hospital_info'] = $this->hospital->getHospitalByID(auth()->user()->org_id);
        } elseif(auth()->user()->role == 4){
        $data['walletBalance'] = $this->branch->getBranchByID(auth()->user()->org_id)->wallet_balance;
        } else{
            $data['walletBalance'] = 0;
        }
        // $data['inactiveAmbulances'] = $this->ambulance->
        // $data['activeAmbulances'] = $this->ambulance->
        return view('panel.dashboard')->with('data', $data)->with('home', true);
    }


    public function update_notify_user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notify_to' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $user = User::where('status', 1)->where('role', 9)->update([
            'notify_to' => $request->input('notify_to'),
        ]);
        if ($user)
            return \redirect(route('dashboard'))->with('success', 'Notify User Updated!');
            //return Redirect::back()->with('success', 'Notify User Updated! '.$redirect_to);
        return Redirect::back()->with('error', 'Please try again');
    }
}

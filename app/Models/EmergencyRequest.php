<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmergencyRequest extends Model
{
    use HasFactory;

    protected $table = "emergency_requests";
    protected $fillable = [
        'booking_id',
        'counter',
        'branch_id',
        'booking_manager_id',
        'ambulance_id',
        'driver_id',
        'request_time',
        'action_time',
        'status'
    ];

    public function getEmergencyRequestByToken($bookingID){
        return EmergencyRequest::where('status', 1)->where('booking_id', $bookingID)->get();
    }


    /**
     * Api
     **/

    public function getFirstBranchByBookingID($bookingID){
        return DB::table('bookings as b')
            ->join('emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('er.*', 'u.name as userName', 'u.username as userPhone', 'b.user_latitude', 'b.user_longitude','b.booking_id')
            ->where('u.role', 8)
            ->where('er.status', 1)
            ->where('er.booking_id', $bookingID)
            ->orderBy('er.id', 'ASC')
            ->limit(1)
            ->first();
    }

    public function getBranchByBookingIDAndBranch($bookingID, $branchID){
        return DB::table('bookings as b')
            ->join('emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('er.*', 'u.name as userName', 'u.username as userPhone', 'b.user_latitude', 'b.user_longitude')
            ->where('u.role', 8)
            ->where('er.status', 1)
            ->where('er.booking_id', $bookingID)
            ->where('er.branch_id', '!=', $branchID)
            ->orderBy('er.id', 'ASC')
            ->limit(1)
            ->first();
    }

    public function getBranchByBookingIDAndBranchNewFunction($bookingID, $branchID){
        return DB::table('bookings as b')
            ->join('emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('er.*', 'u.name as userName', 'u.username as userPhone', 'b.user_latitude', 'b.user_longitude')
            ->where('u.role', 8)
            ->where('er.booking_id', $bookingID)
            ->orderBy('er.id', 'ASC')
            ->limit(1)
            ->first();
    }


    /**
     * Private Ambulance Api
     **/

    public function getFirstAmbulanceByBookingID($bookingID){
        return DB::table('bookings as b')
            ->join('emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('er.*', 'u.name as userName', 'u.username as userPhone', 'b.user_latitude', 'b.user_longitude')
            ->where('u.role', 8)
            ->where('er.status', 1)
            ->where('er.booking_id', $bookingID)
            ->orderBy('er.id', 'ASC')
            ->limit(1)
            ->first();
    }

    public function getAmbulanceByBookingIDAndDriver($bookingID, $driverID){
        return DB::table('bookings as b')
            ->join('emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('er.*', 'u.name as userName', 'u.username as userPhone', 'b.user_latitude', 'b.user_longitude')
            ->where('u.role', 8)
            ->where('er.status', 1)
            ->where('er.booking_id', $bookingID)
            ->where('er.driver_id', '!=', $driverID)
            ->orderBy('er.id', 'ASC')
            ->limit(1)
            ->first();
    }
}

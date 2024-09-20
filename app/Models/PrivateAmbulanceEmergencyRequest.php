<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrivateAmbulanceEmergencyRequest extends Model
{
    use HasFactory;

    protected $table = "private_ambulance_emergency_requests";
    protected $fillable = [
        'booking_id',
        'counter',
        'admin_id',
        'ambulance_id',
        'booking_manager_id',
        'driver_id',
        'request_time',
        'action_time',
        'notify_to',
        'status'
    ];

    public function getEmergencyRequestByToken($bookingID){
        return PrivateAmbulanceEmergencyRequest::where('status', 1)->where('booking_id', $bookingID)->get();
    }


    /**
     * Api
     **/

    public function getFirstAmbulanceByBookingID($bookingID){
        return DB::table('private_ambulance_bookings as b')
            ->join('private_ambulance_emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
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
        return DB::table('private_ambulance_bookings as b')
            ->join('private_ambulance_emergency_requests as er', 'er.booking_id', '=', 'b.booking_id')
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

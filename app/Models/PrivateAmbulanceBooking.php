<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PrivateAmbulanceBooking extends Model
{
    use HasFactory;

    protected $table = "private_ambulance_bookings";
    protected $fillable = [
        'booking_id',
        'user_id',
        'user_latitude',
        'user_longitude',
        'user_destination_latitude',
        'user_destination_longitude',
        'ambulance_type_id',
        'amenities_ids',
        'admin_id',
        'ambulance_id',
        'driver_id',
        'booking_manager_id',
        'route_array',
        'driver_otp',
        'user_otp',
        'driver_status',
        'status',
        'cancel_reason',
        'cancel_by',
        'cancel_by_id',
        'payment_amount',
        'payment_type',
        'payment_date',
        'payment_time',
        'payment_reference',
        'payment_status',
        'respond_time'
    ];


    /**
     * Api
     **/

    public function getApiAllBooking($day)
    {
        $booking = DB::table('private_ambulance_bookings as b')
            ->join('private_ambulances as a', 'a.id', '=', 'b.ambulance_id')
            ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            ->where('d.role', 10)
            ->where('u.role', 8);
        if (auth()->user()->role == 8) {
            $booking->where('b.user_id', auth()->user()->id);
        } elseif (auth()->user()->role == 10) {
            $booking->where('b.driver_id', auth()->user()->id);
        } else {
            $booking->where('b.admin_id', auth()->user()->org_id);
        }
        if ($day == 1) {
            return $booking->whereDate('b.created_at', Carbon::today())->get();
        } else {
            return $booking->get();
        }

    }

    public function getApiActiveBooking()
    {
        $booking = DB::table('private_ambulance_bookings as b')
            ->join('private_ambulances as a', 'a.id', '=', 'b.ambulance_id')
            ->join('private_ambulance_types as at', 'at.id', '=', 'b.ambulance_type_id')
            ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'a.vehicle_number as vehicle_number', 'at.name as ambulanceTypeName', 'd.name as driverName', 'd.username as driverPhone')
            ->where('d.role', 10)
            ->where('u.role', 8)
            ->where('b.status', 3);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role == 10) {
            return $booking->where('b.driver_id', auth()->user()->id)->get();
        } else {
            return $booking->where('b.admin_id', auth()->user()->org_id)->get();
        }
    }

    public function getApiBookingByID($bookingID)
    {
        $booking = DB::table('private_ambulance_bookings as b')
            ->join('private_ambulances as a', 'a.id', '=', 'b.ambulance_id')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'a.vehicle_number as vehicle_number', 'at.name as ambulanceTypeName',
                'd.name as driverName', 'd.username as driverPhone')
            ->where('d.role', 10)
            ->where('u.role', 8)
            ->whereIn('b.status', [3, 5])
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 10) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->where('b.admin_id', auth()->user()->org_id)->first();
        }
    }

    public function getApiBookingByBookingID($bookingID)
    {
        $booking = DB::table('private_ambulance_bookings as b')
            ->join('private_ambulances as a', 'a.id', '=', 'b.ambulance_id')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'a.vehicle_number as vehicle_number', 'at.name as ambulanceTypeName',
                'd.name as driverName', 'd.username as driverPhone')
            ->where('d.role', 10)
            ->where('u.role', 8)
            ->whereIn('b.status', [1, 2, 3])
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 10) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->first();
        }
    }

    public function getApiBookingByIDForNotification($bookingID, $status)
    {
        $booking = DB::table('private_ambulance_bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*',  'u.name as userName', 'u.username as userPhone')
            ->where('u.role', 8)
            ->where('b.status', $status)
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 10) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->first();
        }
    }

    public function getBookingByBookingIDAndUser($bookingID)
    {
        return DB::table('private_ambulance_bookings as b')
            ->leftJoin('private_ambulances as a', function ($join) {
                $join->on('a.id', '=', 'b.ambulance_id');
            })
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                    ->where('d.role', 10);
            })
            ->select('b.*', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            ->where('b.booking_id', $bookingID)
            ->where('user_id', auth()->user()->id)
            ->first();
    }


    
    public function getApiBookingByIDForCheck($bookingID)
    {
        return DB::table('private_ambulance_bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*',  'u.name as userName', 'u.username as userPhone')
            ->where('u.role', 8)
            ->where('b.booking_id', $bookingID)
            ->first();
    }
}

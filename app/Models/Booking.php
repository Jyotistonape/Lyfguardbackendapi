<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $table = "bookings";
    protected $fillable = [
        'booking_id',
        'user_id',
        'user_latitude',
        'user_longitude',
        'emergency_type_id',
        'branch_id',
        'booking_manager_id',
        'ambulance_id',
        'driver_id',
        'route_array',
        'booking_manager_otp',
        'user_otp',
        'driver_status',
        'status',
        'cancel_reason',
        'cancel_by',
        'cancel_by_id',
        'respond_time'
    ];
    
    
    
    public function getAllBooking($status)
    {
        $booking = DB::table('bookings as b')
            ->join('branches as bs', 'bs.id', '=', 'b.branch_id')
            ->join('hospitals as h', 'h.id', '=', 'bs.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'bs.type_id')
            ->join('ambulances as a', 'a.id', '=', 'b.ambulance_id')
            ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'bs.name as branchName', 'h.name as hospitalName', 'bt.name as branchTypeName', 'bs.latitude as branchLatitude', 'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            ->where('d.role', 6)
            ->where('u.role', 8);
        if (auth()->user()->role == 8) {
            $booking->where('b.user_id', auth()->user()->id);
        } elseif (auth()->user()->role == 6) {
            $booking->where('b.driver_id', auth()->user()->id);
        } else {
            $booking->where('b.branch_id', auth()->user()->org_id);
        }
        if ($status != 0) {
            return $booking->where('b.status', $status)->get();
        } else {
            return $booking->get();
        }

    }

    /**
     * Api
     **/

    public function getApiAllBooking($day)
    {
        $booking = DB::table('bookings as b')
            ->join('branches as bs', 'bs.id', '=', 'b.branch_id')
            ->join('hospitals as h', 'h.id', '=', 'bs.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'bs.type_id')
            // ->join('ambulances as a', 'a.id', '=', 'b.ambulance_id')
            // ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                    ->where('d.role', 6);
            })
            ->leftJoin('ambulances as a', function ($join) {
                $join->on('a.id', '=', 'b.ambulance_id');
            })
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'bs.name as branchName', 'h.name as hospitalName', 'bt.name as branchTypeName', 'bs.latitude as branchLatitude', 'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            // ->where('d.role', 6)
            ->where('u.role', 8);
        if (auth()->user()->role == 8) {
            $booking->where('b.user_id', auth()->user()->id);
        } elseif (auth()->user()->role == 6) {
            $booking->where('b.driver_id', auth()->user()->id);
        } else {
            $booking->where('b.branch_id', auth()->user()->org_id);
        }
        if ($day == 1) {
            return $booking->whereDate('b.created_at', Carbon::today())->get();
        } else {
            return $booking->get();
        }

    }

    public function getApiActiveBooking()
    {
        $booking = DB::table('bookings as b')
            ->join('branches as bs', 'bs.id', '=', 'b.branch_id')
            ->join('hospitals as h', 'h.id', '=', 'bs.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'bs.type_id')
            // ->join('ambulances as a', 'a.id', '=', 'b.ambulance_id')
            // ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                    ->where('d.role', 6);
            })
            ->leftJoin('ambulances as a', function ($join) {
                $join->on('a.id', '=', 'b.ambulance_id');
            })
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'bs.name as branchName', 'h.name as hospitalName', 'bt.name as branchTypeName', 'bs.latitude as branchLatitude', 'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            // ->where('d.role', 6)
            ->where('u.role', 8)
            // ->where('b.status', 4);
            ->whereIn('b.status', [3,4,5,6]);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role == 6) {
            return $booking->where('b.driver_id', auth()->user()->id)->get();
        } else {
            return $booking->where('b.branch_id', auth()->user()->org_id)->get();
        }
    }

    public function getApiBookingByID($bookingID)
    {
        $booking = DB::table('bookings as b')
            ->join('branches as bs', 'bs.id', '=', 'b.branch_id')
            ->join('emergency_types as et', 'et.id', '=', 'b.emergency_type_id')
            ->join('hospitals as h', 'h.id', '=', 'bs.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'bs.type_id')
            // ->join('ambulances as a', 'a.id', '=', 'b.ambulance_id')
            // ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            // ->join('users as d', 'd.id', '=', 'b.driver_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                    ->where('d.role', 6);
            })
            ->leftJoin('ambulances as a', function ($join) {
                $join->on('a.id', '=', 'b.ambulance_id');
            })
            ->leftJoin('ambulance_types as at', function ($join) {
                $join->on('at.id', '=', 'a.type_id');
            })
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->join('users as bm', 'bm.id', '=', 'b.booking_manager_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'bs.name as branchName', 'et.name as emergencyTypeName',
                'h.name as hospitalName', 'bt.name as branchTypeName', 'bs.latitude as branchLatitude',
                'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'at.name as ambulanceTypeName',
                'd.name as driverName', 'd.username as driverPhone', 'bm.name as bookingManagerName',
                'bm.username as bookingManagerPhone')
            // ->where('d.role', 6)
            ->where('u.role', 8)
            ->where('bm.role', 5)
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 6) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->where('b.branch_id', auth()->user()->org_id)->first();
        }
    }

    public function getApiBookingByBookingID($bookingID)
    {
        $booking = DB::table('bookings as b')
            ->join('emergency_types as et', 'et.id', '=', 'b.emergency_type_id')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->leftJoin('branches as bs', 'bs.id', '=', 'b.branch_id')
            ->leftJoin('hospitals as h', 'h.id', '=', 'bs.hospital_id')
            ->leftJoin('branch_types as bt', 'bt.id', '=', 'bs.type_id')
            ->leftJoin('ambulances as a', 'a.id', '=', 'b.ambulance_id')
            ->leftJoin('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                ->where('d.role', 6);
                })
            ->leftJoin('users as bm', function ($join) {
                $join->on('bm.id', '=', 'b.booking_manager_id')
                ->where('bm.role', 5);
                })
                
//             ->join('branches as bs', 'bs.id', '=', 'b.branch_id')
//             ->join('hospitals as h', 'h.id', '=', 'bs.hospital_id')
//             ->join('branch_types as bt', 'bt.id', '=', 'bs.type_id')
//             ->join('ambulances as a', 'a.id', '=', 'b.ambulance_id')
//             ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
//             ->join('users as d', 'd.id', '=', 'b.driver_id')
//             ->join('users as bm', 'bm.id', '=', 'b.booking_manager_id')
            ->select('b.*', 'u.name as userName', 'u.username as userPhone', 'bs.name as branchName', 'et.name as emergencyTypeName',
                'h.name as hospitalName', 'bt.name as branchTypeName', 'bs.latitude as branchLatitude',
                'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'at.name as ambulanceTypeName',
                'd.name as driverName', 'd.username as driverPhone', 'bm.name as bookingManagerName',
                'bm.username as bookingManagerPhone')
//             ->where('d.role', 6)
            ->where('u.role', 8)
//             ->where('bm.role', 5)
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 6) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->where('b.branch_id', auth()->user()->org_id)->first();
        }
    }
    
    public function getApiBookingByBID($bookingID)
    {
        $booking = DB::table('bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*',  'u.name as userName', 'u.username as userPhone')
            ->where('u.role', 8)
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 6) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->where('b.branch_id', auth()->user()->org_id)->first();
        }
    }

    public function getApiBookingByIDForNotification($bookingID, $status)
    {
        $booking = DB::table('bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*',  'u.name as userName', 'u.username as userPhone')
            ->where('u.role', 8)
            ->where('b.status', $status)
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 6) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->where('b.branch_id', auth()->user()->org_id)->first();
        }
    }

    public function getApiBookingByIDAndDriverStatusForNotification($bookingID, $driverStatus)
    {
        $booking = DB::table('bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*',  'u.name as userName', 'u.username as userPhone')
            ->where('u.role', 8)
            ->where('b.status', $driverStatus)
            ->where('b.booking_id', $bookingID);
        if (auth()->user()->role == 8) {
            return $booking->where('b.user_id', auth()->user()->id)->first();
        } elseif (auth()->user()->role == 6) {
            return $booking->where('b.driver_id', auth()->user()->id)->first();
        } else {
            return $booking->where('b.branch_id', auth()->user()->org_id)->first();
        }
    }

    public function getBookingByBookingIDAndUser($bookingID)
    {
        return DB::table('bookings as b')
            ->leftJoin('branches as bs', function ($join) {
                $join->on('bs.id', '=', 'b.branch_id');
            })
            ->leftJoin('ambulances as a', function ($join) {
                $join->on('a.id', '=', 'b.ambulance_id');
            })
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'b.driver_id')
                    ->where('d.role', 6);
            })
            ->select('b.*', 'bs.name as branchName', 'bs.phone as branchPhone', 'bs.latitude as branchLatitude', 'bs.longitude as branchLongitude', 'a.vehicle_number as vehicle_number', 'd.name as driverName', 'd.username as driverPhone')
            ->where('b.booking_id', $bookingID)
            ->where('user_id', auth()->user()->id)
            ->first();
    }
    
    
    public function getApiBookingByIDForCheck($bookingID)
    {
        return DB::table('bookings as b')
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->select('b.*',  'u.name as userName', 'u.username as userPhone')
            ->where('u.role', 8)
            ->where('b.booking_id', $bookingID)
            ->first();
    }
}

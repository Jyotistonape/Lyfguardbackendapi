<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrivateAmbulance extends Model
{
    use HasFactory;

    protected $table = "private_ambulances";
    protected $fillable = [
        'admin_id',
        'vehicle_number',
        'type_id',
        'latitude',
        'longitude',
        'insurance_date',
        'registration_certificate',
        'zero_five_km_rate',
        'five_fifteen_km_rate',
        'fifteen_thirty_km_rate',
        'thirty_above_km_rate',
        'running_status',
        'driver_id',
        'amenities',
        'available_amenities',
        'status'
    ];

    public function getAllAmbulance()
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'a.driver_id')
                    ->where('d.role', 10);
            })
            ->select('a.*', 'at.name as typeName', 'd.name as driverName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.admin_id', auth()->user()->id)
            ->get();
    }


    /**
     * Api
     **/



    public function getApiAllAmbulance()
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'a.driver_id')
                    ->where('d.role', 10);
            })
            ->select('a.*', 'at.name as typeName', 'd.name as driverName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->where('a.admin_id', auth()->user()->org_id)
            ->get();
    }

    public function getApiAmbulanceByID($id, $runningStatus)
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'a.driver_id')
                    ->where('d.role', 10);
            })
            ->select('a.*', 'at.name as typeName', 'd.name as driverName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.id', $id)
            ->where('a.running_status', $runningStatus)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->where('a.admin_id', auth()->user()->org_id)
            ->first();
    }

    public function getApiAllOnDutyAmbulanceByID($ambulanceID)
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->join('users as u', 'u.id', '=', 'a.driver_id')
            ->select('a.*', 'at.name as typeName', 'u.name as driverName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.id', $ambulanceID)
            ->where('a.running_status', 1)
            ->where('u.role', 10)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->first();
    }


    public function getApiAllOnDutyAmbulanceByLatLogAndType($ambulanceType, $latitude, $longitude)
    { 
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->join('users as u', 'u.id', '=', 'a.driver_id')
            ->select(  'a.*', 'at.name as typeName', 'u.name as driverName','at.id as at_id', 'pa.name as adminName', 'pa.notify_to as adminNotifyTo'
               , DB::raw("
                           (3959 * ACOS(COS(RADIANS($latitude))
                               * COS(RADIANS(latitude))
                               * COS(RADIANS($longitude) - RADIANS(longitude))
                               + SIN(RADIANS($latitude))
                               * SIN(RADIANS(latitude)))) AS distance")
            )
            ->where('at.status', '1')
            ->where('a.type_id', $ambulanceType)
            ->where('a.status', 1)
            ->where('a.running_status', 1)
            ->where('u.role', 10)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
           ->orderBy('distance', 'ASC')
            // ->orderBy('at.id', 'ASC')
            ->limit(3)
            ->distinct()
            ->get();
    }

    public function getDriverApiAllAmbulance()
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->select('a.*', 'at.name as typeName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.running_status', 0)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->where('a.admin_id', auth()->user()->org_id)
            ->get();
    }

    public function getApiDriverCurrentAmbulance()
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->select('a.*', 'at.name as ambulanceTypeName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.driver_id', auth()->user()->id)
            ->where('a.running_status', '!=',  0)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->where('a.admin_id', auth()->user()->org_id)
            ->first();
    }

    public function getApiDriverCurrentAmbulanceByAmbulanceID($ambulanceID)
    {
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->select('a.*', 'at.name as ambulanceTypeName')
            ->where('at.status', '1')
            ->where('a.status', 1)
            ->where('a.driver_id', auth()->user()->id)
            ->where('a.id', $ambulanceID)
            ->where('a.running_status', '!=',  0)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->where('a.admin_id', auth()->user()->org_id)
            ->first();
    }

    public function getApiAmbulanceByAmbulanceID($ambulanceID)
    {
        
        return DB::table('private_ambulances as a')
            ->join('private_ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as pa', 'pa.id', '=', 'a.admin_id')
            ->select('a.*', 'at.name as ambulanceTypeName')
            ->where('at.status', '1')
            ->where('a.status', 1)
            ->where('a.id', $ambulanceID)
            ->where('pa.status', 1)
            ->where('pa.role', 9)
            ->where('a.admin_id', auth()->user()->org_id)
            ->first();
    }
}

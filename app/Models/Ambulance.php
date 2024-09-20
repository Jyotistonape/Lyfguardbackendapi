<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ambulance extends Model
{
    use HasFactory;

    protected $table = "ambulances";
    protected $fillable = [
        'branch_id',
        'vehicle_number',
        'type_id',
        'running_status',
        'driver_id',
        'insurance_date',
        'documents',
        'status'
    ];

    public function getAllAmbulance()
    {
        return DB::table('ambulances as a')
            ->join('branches as b', 'b.id', '=', 'a.branch_id')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'a.driver_id')
                ->where('d.role', 6);
            })
            ->select('a.*', 'b.name as branchName', 'at.name as typeName', 'd.name as driverName')
            ->where('b.status', 1)
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', auth()->user()->org_id)
            ->get();
    }

    public function getAmbulanceByAmbulanceID($ambulance_id)
    {
        return DB::table('ambulances as a')
            ->join('branches as b', 'b.id', '=', 'a.branch_id')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'a.driver_id')
                ->where('d.role', 6);
            })
            ->select('a.*', 'b.name as branchName', 'at.name as typeName', 'd.name as driverName')
            ->where('b.status', 1)
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', auth()->user()->org_id)
            ->where('a.id',$ambulance_id)
            ->latest()
            ->first();
    }


    /**
     * DriverApp
     **/



    public function getApiAllAmbulance()
    {
        return DB::table('ambulances as a')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->leftJoin('users as d', function ($join) {
                $join->on('d.id', '=', 'a.driver_id')
                    ->where('d.role', 6);
            })
            ->select('a.*', 'at.name as typeName', 'd.name as driverName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', auth()->user()->org_id)
            ->get();
    }


    public function getApiAllOnDutyAmbulanceByBranch($branchID)
    {
        return DB::table('ambulances as a')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->join('users as u', 'u.id', '=', 'a.driver_id')
            ->select('a.*', 'at.name as typeName', 'u.name as driverName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', $branchID)
            ->where('a.running_status', 1)
            ->where('u.role', 6)
            ->get();
    }

    public function getDriverApiAllAmbulance()
    {
        return DB::table('ambulances as a')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->select('a.*', 'at.name as typeName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', auth()->user()->org_id)
            ->where('a.running_status', 0)
            ->get();
    }

    public function getApiDriverCurrentAmbulance()
    {
        return DB::table('ambulances as a')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->select('a.*', 'at.name as ambulanceTypeName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', auth()->user()->org_id)
            ->where('a.driver_id', auth()->user()->id)
            ->where('a.running_status', '!=',  0)
            ->first();
    }

    public function getApiDriverCurrentAmbulanceByAmbulanceID($ambulanceID)
    {
        return DB::table('ambulances as a')
            ->join('ambulance_types as at', 'at.id', '=', 'a.type_id')
            ->select('a.*', 'at.name as ambulanceTypeName')
            ->where('at.status', 1)
            ->where('a.status', 1)
            ->where('a.branch_id', auth()->user()->org_id)
            ->where('a.driver_id', auth()->user()->id)
            ->where('a.id', $ambulanceID)
            ->where('a.running_status', '!=',  0)
            ->first();
    }
}

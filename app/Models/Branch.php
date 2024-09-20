<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Branch extends Model
{
    use HasFactory;

    protected $table = "branches";
    protected $fillable = [
        'hospital_id',
        'slug',
        'name',
        'type_id',
        'speciality_ids',
        'is_partner',
        'emergency_type_ids',
        'website',
        'phone',
        'address_line1',
        'address_line2',
        'country',
        'state',
        'city',
        'latitude',
        'longitude',
        'pincode',
        'is_emergency',
        'wallet_balance',
        'status'
    ];

    public function getAllBranch()
    {
        $branches = DB::table('branches as b')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->join('users as u', 'u.org_id', '=', 'b.id')
            ->select('b.*', 'h.name as hospitalName', 'u.id as userID', 'u.role as userRole',
                'u.org_id as userOrgID', 'u.name as userName', 'u.username as userEmail', 'u.image as userImage',
                'bt.name as typeName')
            ->where('u.status', 1)
            ->where('u.role', 4)
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1);
        if (auth()->user()->role == 1) {
            return $branches->get();
        } else {
            return $branches->where('b.hospital_id', auth()->user()->org_id)->get();
        }
    }
    
    
    
    public function getBranchByID($branchID)
    {
        return Branch::where('id', $branchID)->where('status', 1)->first();
    }
    /**
     * API
     *
     **/

    public function getApiBranchByLatitudeAndLongitude($latitude, $longitude)
    {
        return DB::table('branches as b')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->join('users as u', 'u.org_id', '=', 'b.id')
            ->leftJoin('preferred_hospitals as ph', function ($join) {
                $join->on('ph.branch_id', '=', 'b.id')
                    ->where('ph.status', 1)
                    ->where('ph.user_id', auth()->user()->id)
                    ->groupBy('ph.branch_id');
            })
            ->select(  'b.*', 'h.name as hospitalName', 'bt.name as branchTypeName', 'u.name as mangerName',
                'u.username as mangerUserName', 'u.id as mangerUserID', 'ph.status as isPreferred',
                DB::raw("
                            (3959 * ACOS(COS(RADIANS($latitude))
                                * COS(RADIANS(latitude))
                                * COS(RADIANS($longitude) - RADIANS(longitude))
                                + SIN(RADIANS($latitude))
                                * SIN(RADIANS(latitude)))) AS distance"))
            ->orderBy('distance', 'ASC')
            ->where('u.role', 4)
            ->where('u.status', 1)
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1)
            ->get();

    }

    public function getApiBranchByLatLong($emergencyTypeID, $latitude, $longitude)
    {
        return DB::table('branches as b')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->join('users as u', 'u.org_id', '=', 'b.id')
            ->join('ambulances', function ($join) {
                $join->on('ambulances.branch_id', '=', 'b.id')
                    ->where('ambulances.running_status', 1)
                    ->where('ambulances.status', 1)->groupBy('ambulances.branch_id');
            })
            ->select(  'b.*', 'h.name as hospitalName', 'bt.name as branchTypeName', 'u.name as mangerName',
                'u.username as mangerUserName', 'u.id as mangerUserID',
                DB::raw("
                            (3959 * ACOS(COS(RADIANS($latitude))
                                * COS(RADIANS(latitude))
                                * COS(RADIANS($longitude) - RADIANS(longitude))
                                + SIN(RADIANS($latitude))
                                * SIN(RADIANS(latitude)))) AS distance"))
            ->orderBy('distance', 'ASC')
            ->limit(3)
//            ->where('u.status', 1)
//            ->whereRaw('FIND_IN_SET("'.$emergencyTypeID.'", b.emergency_type_ids)')
//            ->whereRaw("find_in_set('".$emergencyTypeID."',b.emergency_type_ids)")
//            ->where('u.role', 5)
//            ->where('u.status', 1)
            ->where('u.duty_status', 1)
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1)
            ->where('b.is_partner', 1)
            ->distinct()
//            ->where('a.status', 1)
//            ->where('at.status', 1)
            ->get();

    }

    public function getApiBranchByBranchID($branchID)
    {
        return DB::table('branches as b')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->join('users as u', 'u.org_id', '=', 'b.id')
            ->join('ambulances as a', 'a.branch_id', '=', 'b.id')
            ->select(  'b.*', 'h.name as hospitalName', 'bt.name as branchTypeName', 'u.name as mangerName',
                'u.username as mangerUserName', 'u.id as mangerUserID')
            ->where('u.role', 5)
            ->where('u.status', 1)
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1)
            ->where('b.id', $branchID)
            ->where('a.status', 1)
            ->where('a.running_status', 1)
            ->first();

    }

    public function getApiBokkingManagerBranchByBranchID($branchID)
    {
        return DB::table('branches as b')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->select(  'b.*', 'h.name as hospitalName', 'bt.name as branchTypeName')
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1)
            ->where('b.is_partner', 1)
            ->where('b.id', $branchID)
            ->first();

    }

    // Get Branch Hospital Type
    public function getHospitalType(){
        return $this->belongsTo('App\Models\Hospital', 'hospital_id');
    }

    // Get Branch Type
    public function getBranchType(){
        return $this->belongsTo('App\Models\BranchType', 'type_id');
    }

    // Get Branch Emergency Type
    public function getEmergencyType(){
        return $this->belongsTo('App\Models\EmergencyType', 'emergency_type_ids');
    }

    // Get Branch Admin Details
    public function getAdminDetails(){
        return $this->hasOne('App\Models\User', 'org_id');
    }
}

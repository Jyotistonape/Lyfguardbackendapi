<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DriverDetail extends Model
{
    use HasFactory;

    protected $table = "driver_details";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'licence_number',
        'blood_group',
        'address_line1',
        'address_line2',
        'country',
        'state',
        'city',
        'latitude',
        'longitude',
        'pincode',
        'status'
    ];

    public function getAllDriver()
    {
        return DB::table('users as u')
            ->join('driver_details as dd', 'dd.user_id', '=', 'u.id')
            ->select('dd.*', 'u.id as userID', 'u.username as userPhone', 'u.name as userName')
            ->where('dd.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 6)
            ->where('u.org_id', auth()->user()->org_id)
            ->get();
    }

    /*
     * Api
     */

    public function getApiAllDriver()
    {
        return DB::table('users as u')
            ->join('driver_details as dd', 'dd.user_id', '=', 'u.id')
            ->select('dd.*', 'u.id as userID', 'u.username as userPhone', 'u.name as userName')
            ->where('dd.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 6)
            ->where('u.org_id', auth()->user()->org_id)
            ->get();
    }

    public function getApiDriverProfile()
    {
        return DB::table('users as u')
            ->join('driver_details as dd', 'dd.user_id', '=', 'u.id')
            ->join('branches as b', 'b.id', '=', 'u.org_id')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->select('dd.*', 'u.id as userID', 'u.username as userPhone', 'u.name as userName', 'b.name as branchName', 'h.name as hospitalName', 'bt.name as branchTypeName')
            ->where('dd.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 6)
            ->where('u.id', auth()->user()->id)
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1)
            ->get();
    }

}

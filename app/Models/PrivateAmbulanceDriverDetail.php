<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PrivateAmbulanceDriverDetail extends Model
{
    use HasFactory;

    protected $table = "private_ambulance_driver_details";
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
            ->join('private_ambulance_driver_details as dd', 'dd.user_id', '=', 'u.id')
            ->select('dd.*', 'u.id as userID', 'u.name as userName', 'u.username as username')
            ->where('dd.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 10)
            ->where('u.org_id', auth()->user()->id)
            ->get();
    }

    /*
     * Api
     */

    public function getApiAllDriver()
    {
        return DB::table('users as u')
            ->join('private_ambulance_driver_details as dd', 'dd.user_id', '=', 'u.id')
            ->select('dd.*', 'u.id as userID', 'u.name as userName')
            ->where('dd.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 10)
            ->get();
    }

    public function getApiDriverProfile()
    {
        return DB::table('users as u')
            ->join('private_ambulance_driver_details as dd', 'dd.user_id', '=', 'u.id')
            ->select('dd.*', 'u.id as userID', 'u.name as userName')
            ->where('dd.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 10)
            ->where('u.id', auth()->user()->id)
            ->get();
    }

}

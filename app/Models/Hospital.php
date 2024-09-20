<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hospital extends Model
{
    use HasFactory;

    protected $table = "hospitals";
    protected $fillable = [
        'slug',
        'name',
        'logo',
        'banner',
        'website',
        'type_id',
        'wallet_balance',
        'status'
    ];

    public function getAllHospital()
    {
        return DB::table('hospitals as h')
            ->join('users as u', 'u.org_id', '=', 'h.id')
            ->join('hospital_types as ht', 'ht.id', '=', 'h.type_id')
            ->select('h.*', 'u.id as userID', 'u.name as userName', 'u.username as userEmail', 'u.image as userImage', 'ht.name as typeName')
            ->where('u.status', 1)
            ->where('ht.status', 1)
            ->where('h.status', 1)
            ->where('u.role', 3)
            ->get();
    }

    public function getHospitalByID($ID)
    {
        return DB::table('hospitals as h')
            ->join('users as u', 'u.org_id', '=', 'h.id')
            ->join('hospital_types as ht', 'ht.id', '=', 'h.type_id')
            ->select('h.*', 'u.id as userID', 'u.name as userName', 'u.username as userEmail', 'u.image as userImage', 'ht.name as typeName')
            ->where('u.status', 1)
            ->where('ht.status', 1)
            ->where('h.status', 1)
            ->where('h.id', $ID)
            ->first();
    }
}

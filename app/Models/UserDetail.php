<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = "user_details";
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'gender',
        'blood_group',
        'dob',
        'status'
    ];

    public function getAllUser(){
        return DB::table('users as u')
            ->join('user_details as ud', 'ud.user_id', '=', 'u.id')
            ->select('u.*', 'ud.name as userName', 'ud.email as userEmail', 'ud.phone as userPhone',
                'ud.gender as userGender', 'ud.blood_group as userBloodGroup', 'ud.dob as userDOB')
            ->where('ud.status', 1)
            ->where('u.status', 1)
            ->where('u.role', 8)
            ->get();
    }

    public function getApiUserDetailsByUserID(){
        return UserDetail::where('status', 1)->where('user_id', auth()->user()->id)->first();
    }
}

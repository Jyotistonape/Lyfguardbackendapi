<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PreferredHospital extends Model
{
    use HasFactory;

    protected $table = "preferred_hospitals";
    protected $fillable = [
        'user_id',
        'branch_id',
        'status'
    ];

    public function getApiPreferredHospital()
    {
        return DB::table('preferred_hospitals as ph')
            ->join('branches as b', 'b.id', '=', 'ph.branch_id')
            ->join('hospitals as h', 'h.id', '=', 'b.hospital_id')
            ->join('branch_types as bt', 'bt.id', '=', 'b.type_id')
            ->join('users as u', 'u.org_id', '=', 'b.id')
            ->select(  'b.*', 'h.name as hospitalName', 'bt.name as branchTypeName', 'u.name as mangerName',
                'u.username as mangerUserName', 'u.id as mangerUserID')
            ->where('u.role', 4)
            ->where('u.status', 1)
            ->where('bt.status', 1)
            ->where('h.status', 1)
            ->where('b.status', 1)
            ->where('ph.status', 1)
            ->where('ph.user_id', auth()->user()->id)
            ->get();

    }

    public function getApiPreferredHospitalByBranchID($branchID)
    {
        return DB::table('preferred_hospitals as ph')
            ->select('ph.*')
            ->where('ph.status', 1)
            ->where('ph.user_id', auth()->user()->id)
            ->where('ph.branch_id', $branchID)
            ->first();

    }
}

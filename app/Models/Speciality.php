<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Speciality extends Model
{
    use HasFactory;

    protected $table = "specialities";
    protected $fillable = [
        'slug',
        'name',
        'branch_type_id',
        'status'
    ];

    public function getAllSpeciality($branchType = null)
    {
        $specialities = DB::table('specialities as s')
            ->join('branch_types as bt', 'bt.id', '=', 's.branch_type_id')
            ->select('s.*', 'bt.name as branchTypeName')
            ->where('s.status', 1)
            ->where('bt.status', 1);
        if ($branchType) {
            return $specialities->where('s.branch_type_id', $branchType)->get();
        } else{
            return $specialities->get();
        }
    }

    public function getSpecialityByID($ID)
    {
        return DB::table('specialities as s')
            ->join('branch_types as bt', 'bt.id', '=', 's.branch_type_id')
            ->select('s.*', 'bt.name as branchTypeName')
            ->where('s.status', 1)
            ->where('bt.status', 1)
            ->where('s.id', $ID)
            ->first();
    }
}

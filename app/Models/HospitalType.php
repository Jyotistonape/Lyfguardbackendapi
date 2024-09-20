<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalType extends Model
{
    use HasFactory;

    protected $table = "hospital_types";
    protected $fillable = [
        'slug',
        'name',
        'status'
    ];

    public function getAllType(){

        return HospitalType::where('status', 1)->get();
    }

    public function getTypeByID($id){
        return HospitalType::where('id', $id)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiAllType(){

        return HospitalType::where('status', 1)->get();
    }
}

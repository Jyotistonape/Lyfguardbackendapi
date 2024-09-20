<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyType extends Model
{
    use HasFactory;

    protected $table = "emergency_types";
    protected $fillable = [
        'slug',
        'name',
        'description',
        'status'
    ];

    public function getAllType(){

        return EmergencyType::where('status', 1)->get();
    }

    public function getTypeByID($id){
        return EmergencyType::where('id', $id)->where('status', 1)->first();
    }


    /**
     * Api
     * */


    public function getApiAllType(){

        return EmergencyType::where('status', 1)->get();
    }
}

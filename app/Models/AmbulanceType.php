<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceType extends Model
{
    use HasFactory;

    protected $table = "ambulance_types";
    protected $fillable = [
        'slug',
        'name',
        'image',
        'description',
        'price',
        'has_amenity',
        'minimum_kilometre',
        'maximum_kilometre',
        'status'
    ];

    public function getAllAmbulanceType(){
        return AmbulanceType::where('status', 1)->get();
    }

    public function getAmbulanceTypeByID($id){
        return AmbulanceType::where('id', $id)->where('status', 1)->first();
    }

    /**
     * Api
     */
    public function getApiAllAmbulanceType(){

        return AmbulanceType::where('status', 1)->get();
    }

    public function getApiAmbulanceTypeByID($id){
        return AmbulanceType::where('id', $id)->where('status', 1)->first();
    }
}

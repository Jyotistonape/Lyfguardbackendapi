<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivateAmbulanceType extends Model 
{
    use HasFactory;

    protected $table = "private_ambulance_types";
    protected $fillable = [
        'slug',
        'name',
        'image',
        'description',
        'price',
        'amenities',
        'status'
    ];

    public function getAllAmbulanceType(){

        return PrivateAmbulanceType::where('status', 1)->get();
    }

    public function getAmbulanceTypeByID($id){
        return PrivateAmbulanceType::where('id', $id)->where('status', 1)->first();
    }

    public function getAmbulanceTypeByAmenities(){
        return PrivateAmbulanceType::where('status', 1)->get();
    }


    /*Api
    */


    public function getApiAllAmbulanceType(){

        return PrivateAmbulanceType::where('status', 1)->get();
    }

    public function getApiAmbulanceTypeByAmenities(){
        return PrivateAmbulanceType::where('status', 1)->get();
    }

}
